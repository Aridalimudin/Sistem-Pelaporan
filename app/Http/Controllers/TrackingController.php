<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Reporter;
use App\Models\ReporterHistoryTracking;
use App\Models\Student;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TrackingController extends Controller
{
    public function index(Request $request)
    {

        $reporter = null; 
        $categories = null;
        $sendReporter = null;
        $terkirim = null;
        $verifikasi = null;
        $proses = null;
        $done = null;
        $reject = null;
        $previousStatus = null;
        $rejectFound = false;
        $reporter = Reporter::with(['reporterFile','crime','student','reporterDetail.victims','reporterDetail.perpetrators','reporterDetail.witnesses','operation'])->where('code', $request->code)->first();
        if($reporter){
            if ($reporter->crime) {
                $categories = implode(',', array_unique($reporter->crime->pluck('type')->toArray()));
            } else {
                $categories = 'belum ada kategori';
            }

            $sendReporter = ReporterHistoryTracking::where('reporter_id', $reporter->id)->where('status', 0)->first();
            $terkirim = ReporterHistoryTracking::where('reporter_id', $reporter->id)->where('status', 0)->first();
            $verifikasi = ReporterHistoryTracking::where('reporter_id', $reporter->id)->where('status', 1)->first();
            $proses = ReporterHistoryTracking::where('reporter_id', $reporter->id)->where('status', 2)->first();
            $done = ReporterHistoryTracking::where('reporter_id', $reporter->id)->where('status', 3)->first();
            $reject = ReporterHistoryTracking::where('reporter_id', $reporter->id)->where('status', 4)->first();

           
            $histories =  ReporterHistoryTracking::where('reporter_id', $reporter->id)->get();
            $histories->reverse()->each(function ($history, $key) use (&$previousStatus, &$rejectFound) {
                if ($history->description == 'Reject') {
                    $rejectFound = true;
                } elseif ($rejectFound) {
                    if (in_array($history['description'], ['Terkirim','Approve','Proses'])) {
                        $previousStatus = $history;
                        return false;
                    }
                }
            });
        }

        $rating = @$reporter->rating ? false : true;

        $victimNames = $reporter?->reporterDetail?->victims->map(function ($victim) {
                return $victim->name . ' (' . $victim->classroom . ')';
        })->implode(', ');
        $perpetratorsNames = $reporter?->reporterDetail?->perpetrators->map(function ($perpetrator) {
                return $perpetrator->name . ' (' . $perpetrator->classroom . ')';
        })->implode(', ');
        $witnesNames = $reporter?->reporterDetail?->witnesses->map(function ($witnes) {
                return $witnes->name . ' (' . $witnes->classroom . ')';
        })->implode(', ');

        $students = Student::all()->map(function ($student) {
            return [
                'id' => $student->id,
                'text' => $student->name. ' ('.$student->nis.')', 
            ];
        })->toJson();

        if ($request->code && !$reporter) {

            return redirect()->route('track')->withErrors(['code_not_found' => 'Kode laporan tidak ditemukan.']);
        }

        return view('track_laporan.track', compact('reporter', 'categories','sendReporter','students','terkirim','verifikasi','proses','done','reject','victimNames','perpetratorsNames','witnesNames','previousStatus','rating'));
    }

    public function submitFeedback(Request $request)
    {
        $id = $request->report_id;
        $reporter = Reporter::find($id);

        if (!$reporter) {
            return response()->json([
                'status' => false,
                'message' => 'Laporan tidak ditemukan.' // Report not found
            ], 404);
        }

        DB::beginTransaction(); // Start a database transaction

        try {
            // Update the reporter's feedback information
            $reporter->update([
                'rating' => $request->rating,
                'comment' => $request->comments,
            ]);

            DB::commit(); // Commit the transaction if everything is successful

            return response()->json([
                'status' => true,
                'message' => 'Umpan balik berhasil disimpan.' // Feedback successfully saved
            ], 200);

        } catch (Exception $e) {
            DB::rollBack(); // Rollback the transaction if any error occurs

            // Log the error for debugging purposes
            Log::error('Gagal menyimpan umpan balik untuk laporan ID ' . $id . ': ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat menyimpan umpan balik. Mohon coba lagi.' // An error occurred while saving feedback. Please try again.
            ], 500);
        }
    }
}