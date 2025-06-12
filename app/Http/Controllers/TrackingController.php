<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Reporter;
use App\Models\ReporterHistoryTracking;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function index(Request $request)
    {
        $reporter = Reporter::with(['reporterFile','crime','student'])->where('code', $request->code)->first();
        $categories = null;
        $sendReporter = null;
        if($reporter){
            $categories = implode(',', array_unique($reporter->crime()->pluck('type')->toArray()));
            $sendReporter = ReporterHistoryTracking::where('reporter_id', $reporter->id)->where('status', 0)->first();
        }

        return view('track_laporan.track', compact('reporter', 'categories','sendReporter'));
    }
}
