<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\ApprovalMail;
use App\Models\Operation;
use App\Models\Reporter;
use App\Models\ReporterHistoryTracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\NewReportReceivedMail;
use App\Mail\ProcessingNotificationMail;
use App\Mail\FeedbackReceivedMail;
use App\Mail\ReportAcceptedMail;
use App\Mail\ReportCompletedMail;
use App\Mail\ReportRejectedMail;
use App\Mail\ReportReminderMail;

class ReporterUserController extends Controller
{
    public function index()
    {
        $reporters = Reporter::with(['student', 'crime', 'reporterFile'])->where("status", 0)->orderByDesc('urgency')->get();
        return view('dashboard_Admin.Data_tindakan.tindakan', compact('reporters'));
    }

    public function verifikasi()
    {
        $reporters = Reporter::with(['student', 'crime', 'reporterFile'])->where("status", 1)->orderByDesc('urgency')->get();
        return view('dashboard_Admin.Laporan_verifikasi.verifikasi', compact('reporters'));
    }

    public function history()
    {
        $reporters = Reporter::with(['student', 'crime', 'reporterFile'])->where("status", 4)->orderByDesc('urgency')->get();
        return view('dashboard_Admin.History_laporan.history', compact('reporters'));
    }

    public function proses()
    {
        $reporters = Reporter::with(['student', 'crime', 'reporterFile', 'reporterDetail.victims', 'reporterDetail.perpetrators', 'reporterDetail.witnesses'])->where("status", 2)->orderByDesc('urgency')->get();
        $operations = Operation::all();
        return view('dashboard_Admin.Laporan_proses.proses', compact('reporters', 'operations'));
    }

    public function selesai()
    {
        $reporters = Reporter::with(['student', 'crime', 'reporterFile', 'reporterDetail.victims', 'reporterDetail.perpetrators', 'reporterDetail.witnesses'])->where("status", 3)->orderByDesc('urgency')->get();
        return view('dashboard_Admin.Laporan_selesai.selesai', compact('reporters'));
    }

    public function approve(Request $request)
    {
        try {
            $report = Reporter::find($request->id);

            if (!$report) {
                return response()->json(['status' => false]);
            }

            $report->update(['status' => 1]);

            ReporterHistoryTracking::create([
                'reporter_id' => $report->id,
                'status' => 1,
                'username' => Auth::user()->name,
                'description' => 'Approve',
            ]);
            
            // Mengirim notifikasi laporan baru ke BK menggunakan fungsi terpusat
            $this->sendBkNotification($report, 'new_report');

            return response()->json(['status' => true]);
        } catch (\Exception $th) {
            return response()->json(['status' => false]);
        }
    }

    public function reject(Request $request)
    {
        try {
            $report = Reporter::find($request->id);

            if (!$report) {
                return response()->json(['status' => false]);
            }

            $report->update(['status' => 4, 'reason_reject' => $request->reason]);

            ReporterHistoryTracking::create([
                'reporter_id' => $report->id,
                'status' => 4,
                'username' => Auth::user()->name,
                'description' => 'Reject',
            ]);
            $this->sendBkNotification($report, 'reject');

            return response()->json(['status' => true]);
        } catch (\Exception $th) {
            return response()->json(['status' => false]);
        }
    }

    public function prosesAccept(Request $request, Reporter $reporter)
    {
        try {
            DB::beginTransaction();

            $validatedData = $request->all();

            if (empty($validatedData['operation_id'])) {
                // handle error jika perlu
            }

            $reporter->operation_id = $validatedData['operation_id'];
            $reporter->reason = $validatedData['deskripsi'];

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = 'uploads/reporters/' . $fileName;

                Storage::disk('public')->put($filePath, file_get_contents($file));
                Log::info('File berhasil diunggah dan disimpan di: ' . $filePath . ' untuk reporter ID: ' . $reporter->id);

                $reporter->file = $filePath;
            }
            $reporter->status = 3;
            $reporter->save();
            ReporterHistoryTracking::create([
                'reporter_id' => $reporter->id,
                'status' => 3,
                'username' => Auth::user()->name,
                'description' => 'Selesai',
            ]);

            DB::commit();
            $this->sendBkNotification($reporter, 'report_done');
            Log::info('Data reporter berhasil diperbarui.', ['reporter_id' => $reporter->id, 'operation_id' => $reporter->operation_id]);

            return redirect()->back()->with('success', 'Data Laporan berhasil diselesaikan!');
        } catch (Throwable $e) {
            DB::rollBack();

            Log::error('Gagal memperbarui data reporter.', [
                'reporter_id' => $reporter->id,
                'request_data' => $request->all(),
                'error_message' => $e->getMessage(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine(),
            ]);

            return redirect()->back()->with('error', 'Gagal menyelesaikan data laporan. Mohon coba lagi.')->withInput();
        }
    }


    public function startProcessing(Reporter $report)
    {
        $report->update(['status' => 2]); 
        $this->sendBkNotification($report, 'processing');
        return redirect()->back()->with('success', 'Notifikasi proses telah dikirim ke tim.');
    }

    public function addFeedback(Request $request, Reporter $report)
    {
        // Logika untuk menyimpan feedback, misalnya:
        // Feedback::create(['report_id' => $report->id, 'user_id' => Auth::id(), 'content' => $request->feedback_content]);
        $this->sendBkNotification($report, 'feedback');
        return redirect()->back()->with('success', 'Feedback berhasil ditambahkan dan notifikasi terkirim.');
    }

    public function sendReminder(Reporter $report)
    {
        // Cukup panggil fungsi notifikasi dengan tipe 'reminder'
        $this->sendBkNotification($report, 'reminder');
        return redirect()->back()->with('success', 'Email pengingat berhasil dikirim.');
    }


    // --- FUNGSI TERPUSAT UNTUK NOTIFIKASI BK ---

    /**
     * Mengirim email notifikasi kepada Guru BK.
     *
     * @param Reporter $report Objek laporan yang relevan.
     * @param string $type Tipe notifikasi: 'new_report', 'processing', 'feedback', 'reminder'.
     * @return bool
     */
    private function sendBkNotification(Reporter $report, string $type): bool
    {
        $bkEmail = 'aridalimudin@gmail.com'; // Alamat email tujuan untuk semua notifikasi BK

        try {
            $mailable = null;
            switch ($type) {
                case 'new_report':
                    $mailable = new ReportAcceptedMail($report);
                    break;
                case 'processing':
                    $mailable = new ProcessingNotificationMail($report);
                    break;
                case 'feedback':
                    $mailable = new FeedbackReceivedMail($report);
                    break;
                case 'reminder':
                    $mailable = new ReportReminderMail($report);
                    break;
                case 'report_done':
                    $mailable = new ReportCompletedMail($report);
                    break;
                case 'reject':
                    $mailable = new ReportRejectedMail($report);
                    break;
            }

            if ($mailable) {
                Mail::to($bkEmail)->send($mailable);
                return true;
            }
            return false;

        } catch (\Exception $e) {
            Log::error('Gagal mengirim email notifikasi BK: ' . $e->getMessage());
            return false;
        }
    }
}