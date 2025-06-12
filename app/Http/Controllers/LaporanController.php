<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\Crime;
use App\Mail\LaporanStatusNotification;
use Illuminate\Support\Facades\Mail;


class LaporanController extends Controller
{
    /**
     * Store a new report
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_laporan' => 'required|string|unique:laporan',
            'nis' => 'required|string',
            'email' => 'required|email',
            'uraian' => 'required|string',
            'tanggal_lapor' => 'required|date',
            'status' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $laporan = Laporan::create($request->all());
            
            return response()->json([
                'success' => true,
                'message' => 'Laporan berhasil disimpan',
                'data' => $laporan
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan laporan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Upload evidence file
     */
    public function uploadBukti(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'bukti' => 'required|file|max:5120', // Max 5MB
            'id_laporan' => 'required|exists:laporan,id_laporan'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $file = $request->file('bukti');
            $path = $file->store('bukti_laporan', 'public');
            
            $laporan = Laporan::where('id_laporan', $request->id_laporan)->first();
            $laporan->bukti_file = $path;
            $laporan->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Bukti berhasil diupload',
                'data' => ['file_path' => $path]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengupload bukti',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get unverified reports
     */
    public function getUnverified()
    {
        try {
            $reports = Laporan::where('status', 'BELUM_VERIFIKASI')->orderBy('tanggal_lapor', 'desc')->get();
            
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diambil',
                'data' => $reports
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get report details
     */
    public function getDetail($id)
    {
        try {
            $report = Laporan::where('id_laporan', $id)->first();
            
            if (!$report) {
                return response()->json([
                    'success' => false,
                    'message' => 'Laporan tidak ditemukan'
                ], 404);
            }
            
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil diambil',
                'data' => $report
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get reports with status PROSES
     */
    public function getLaporanDiproses()
    {
        try {
            $reports = Laporan::where('status', 'PROSES')
                ->orderBy('tanggal_lapor', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Data laporan dalam proses berhasil diambil',
                'data' => $reports
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data laporan dalam proses',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Verify report
     */
    public function verifyReport(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_laporan' => 'required|exists:laporan,id_laporan',
            'status' => 'required|string|in:PROSES,DITOLAK',
            'catatan' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $report = Laporan::where('id_laporan', $request->id_laporan)->first();
            $report->status = $request->status;
            $report->catatan_verifikasi = $request->catatan;
            $report->tanggal_verifikasi = now();
            $report->save();
            
            return response()->json([
                'success' => true,
                'message' => 'Laporan berhasil diverifikasi',
                'data' => $report
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memverifikasi laporan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function kembalikanLaporan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_laporan' => 'required|exists:laporan,id_laporan',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $report = Laporan::where('id_laporan', $request->id_laporan)->first();
            $report->status = 'BELUM_VERIFIKASI';
            $report->save();

            return response()->json([
                'success' => true,
                'message' => 'Laporan berhasil dikembalikan',
                'data' => $report
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengembalikan laporan',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    public function getHistory()
    {
        try {
            $historyReports = Laporan::with(['user', 'updatedBy'])
                ->whereIn('status', ['DITOLAK', 'DIHAPUS'])
                ->orderBy('tanggal_lapor', 'desc')
                ->get();

            return response()->json([
                'success' => true,
                'message' => 'Data history berhasil diambil',
                'data' => $historyReports
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data history',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    public function getCrimes()
    {
        $crimes = Crime::all('name'); 
        return response()->json($crimes);
    }
}