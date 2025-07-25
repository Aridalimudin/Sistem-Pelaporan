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
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Settings;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
        $reporters = Reporter::with([
            'student',
            'crime',
            'reporterFile',
            'reporterDetail.victims', 
            'reporterDetail.perpetrators',
            'reporterDetail.witnesses' 
        ])->where("status", 4)->orderByDesc('urgency')->get();
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
        $reporters = Reporter::with([
                                'student', 
                                'crime', 
                                'reporterFile', 
                                'reporterDetail.victims', 
                                'reporterDetail.perpetrators', 
                                'reporterDetail.witnesses',
                                'operation'
                            ])
                            ->where("status", 3)
                            ->orderByDesc('urgency')
                            ->get();

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

    public function exportExcel()
    {
        $reporters = Reporter::with(['student', 'crime', 'reporterFile'])->orderByDesc('urgency')->get();

        
        if ($reporters->isEmpty()) {
            return redirect()
                ->route('dashboard')
                ->with('error', 'Data Laporan Tidak Ada');
        }

        $page = "Laporan Data Sistem Monitoring dan Pelaporan Kasus Sekolah";
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet()->setTitle("DATA LAPORAN KASUS SEKOLAH");

        // Set column dimensions
        $columnLetters = range('A', 'Z');
        foreach ($columnLetters as $letter) {
            $sheet->getColumnDimension($letter)->setAutoSize(true);
        }

        // Set page title
        $sheet->setCellValue('A1', $page);
        $sheet->getStyle("A1")->getFont()->setSize(14)->setBold(true);
        $sheet->mergeCells("A1:D1");

        // Set header row
        $headerRow = ['No.', 'Kode', 'Nama Siswa', 'NIS', 'Kelas', 'Email', 'Tanggal Melapor', 'Urgensi', 'Status', 'Deskripsi'];
        $sheet->fromArray([$headerRow], null, 'A3');
        $sheet->getStyle("A3:J3")->getFill()
            ->setFillType(Fill::FILL_SOLID)
            ->getStartColor()
            ->setARGB('b4c6e7');

        // Populate data rows
        $startRow = 4;
        foreach ($reporters as $key => $report) {
            if($report->urgency == 1){
                $urgency = 'Rendah';
            }elseif($report->urgency == 2){
                $urgency = 'Sedang';
            }elseif($report->urgency == 3){
                $urgency = 'Tinggi';
            }else{
                $urgency = '-';
            }

             if($report->status == 0){
                $status = 'Menunggu Approval';
            }elseif($report->status == 1){
                $status = 'Menunggu Kelengkapan Data';
            }elseif($report->status == 2){
                $status = 'Proses';
            }elseif($report->status == 3){
                $status = 'Selesai';
            }elseif($report->status == 4){
                $status = 'Reject';
            }else{
                $status = '-';
            }

            $rowData = [
                $key + 1,
                $report->code ?? '-',
                $report->student?->name ?? '-',
                $report->student?->nis ?? '-',
                $report->student?->classroom ?? '-',
                $report->student?->email ?? '-',
                $report->formatted_created_date ?? '-',
                strtoupper($urgency) ?? '-',
                strtoupper($status) ?? '-',
                $report->description ?? '-',
            ];
            $sheet->fromArray([$rowData], null, 'A' . $startRow);
            $startRow++;
        }

        // Apply styles
        $endRow = $startRow - 1;
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['argb' => '00000000'],
                ],
            ],
        ];
        $sheet->getStyle('A3:J' . $endRow)->applyFromArray($styleArray);

        // Output the spreadsheet
        $writer = new Xlsx($spreadsheet);
        ob_end_clean();
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $page . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');

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