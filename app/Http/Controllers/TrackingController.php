<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Reporter;
use App\Models\ReporterHistoryTracking;
use App\Models\Student;
use Illuminate\Http\Request;

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

        $reporter = Reporter::with(['reporterFile','crime','student','reporterDetail.victims','reporterDetail.perpetrators','reporterDetail.witnesses'])->where('code', $request->code)->first();

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
        }

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

        return view('track_laporan.track', compact('reporter', 'categories','sendReporter','students','terkirim','verifikasi','proses','done','reject','victimNames','perpetratorsNames','witnesNames'));
    }
}