<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Mail\ApprovalMail;
use App\Mail\NotificationMail;
use App\Models\Reporter;
use App\Models\ReporterHistoryTracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ReporterUserController extends Controller
{
    public function index()
    {
        $reporters = Reporter::with(['student','crime','reporterFile'])->where("status", 0)->orderByDesc('urgency')->get();
        return view('dashboard_Admin.Data_tindakan.tindakan', compact('reporters'));
    }

    public function verifikasi()
    {
        $reporters = Reporter::with(['student','crime','reporterFile'])->where("status", 1)->orderByDesc('urgency')->get();
        return view('dashboard_Admin.Laporan_verifikasi.verifikasi', compact('reporters'));
    }

    public function history()
    {
        $reporters = Reporter::with(['student','crime','reporterFile'])->where("status", 4)->orderByDesc('urgency')->get();
        return view('dashboard_Admin.History_laporan.history', compact('reporters'));
    }

    public function proses()
    {
        $reporters = Reporter::with(['student','crime','reporterFile','reporterDetail.victims','reporterDetail.perpetrators','reporterDetail.witnesses'])->where("status", 2)->orderByDesc('urgency')->get();
        return view('dashboard_Admin.Laporan_proses.proses', compact('reporters'));
    }

    public function approve(Request $request)
    {
        try {
            $report = Reporter::find($request->id);

            if(!$report){
                return response()->json([
                    'status' => false,
                ]);
            }

            $report->update(['status' => 1]);

            ReporterHistoryTracking::create([
                'reporter_id' => $report->id,
                'status' => 1,
                'username' => Auth::user()->name,
                'description' => 'Approve',
            ]);
            $this->sendNotificationEmail($report);
            return response()->json([
                'status' => true,
           ]);

        } catch (\Exception $th) {
            return response()->json([
                'status' => false,
           ]);
        }
    }

     public function reject(Request $request)
    {
        try {
            $report = Reporter::find($request->id);

            if(!$report){
                return response()->json([
                    'status' => false,
                ]);
            }

            $report->update(['status' => 4]);

            ReporterHistoryTracking::create([
                'reporter_id' => $report->id,
                'status' => 4,
                'username' => Auth::user()->name,
                'description' => 'Reject',
            ]);

            return response()->json([
                'status' => true,
           ]);
           
        } catch (\Exception $th) {
            return response()->json([
                'status' => false,
           ]);
        }
    }

    private function sendNotificationEmail($data): bool
    {
        try {
            Mail::to('aridalimudin@gmail.com')->send(new ApprovalMail($data));
            return true;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
    }
}
