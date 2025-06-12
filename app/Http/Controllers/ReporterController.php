<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Http\Controllers\Controller;
use App\Mail\NotificationMail;
use App\Models\Crime;
use App\Models\Reporter;
use App\Models\ReporterFile;
use App\Models\ReporterHistoryTracking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ReporterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('lapor.form');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            if(!$request->tags){
                return response()->json([
                    'status' => false,
                    'message' => 'Data tags wajib diisi'
                ]);
            }

            $student = Student::where('nis', $request->nis)->where('email', $request->email)->first();
            if(!$student){
                return response()->json([
                    'status' => false,
                    'message' => 'Data Siswa Tidak Ada, Periksa Kembali NISN dan Email Anda'
                ]);
            }
            
            $exsistReporter = Reporter::where('student_id', $student->id)->where('status', 0)->first();

            if((bool)$exsistReporter){
                return response()->json([
                    'status' => false,
                    'message' => 'Terdapat Laporan yang belum selesai, dengan Data Siswa yang sama'
                ]);
            }

            $crimes = Crime::whereIn('name', json_decode($request->tags, true))->get(['id','name','urgency']);
            if($crimes->isEmpty()){
                return response()->json([
                    'status' => false,
                    'message' => 'Data tags wajib diisi'
                ]);
            }
            $urgency = null;
            foreach ($crimes as $key => $crime) {
                if($crime->urgency == 3){
                    $urgency = 3;
                    break;
                }elseif($crime->urgency == 2){
                    $urgency = 2;
                }elseif($crime->urgency == 1){
                    $urgency = 1;
                }
                
            }

            if(!$urgency){
                return response()->json([
                    'status' => false,
                    'message' => 'Data Perhitungan Gagal'
                ]);
            }
            

            $report = Reporter::create([
                'student_id' => $student->id,
                'code' => 'HTC-'.date('mY').'-'.Str::random(9),
                'description' => $request->uraian,
                'urgency' => $urgency
            ]);

            if($report->id){
                if(!empty($request->image)){
                    foreach ($request->image as $value) {
                        ReporterFile::create([
                            'reporter_id' => $report->id,
                            'file' => $value,
                        ]);
                    }

                }
                $report->crime()->attach(Crime::whereIn('name', json_decode($request->tags, true))->pluck('id')->toArray());
                ReporterHistoryTracking::create([
                    'reporter_id' => $report->id,
                    'status' => 0,
                    'username' => $student->name,
                    'description' => 'Terkirim',
                ]);

                DB::commit();
               $this->sendNotificationEmail($report);
                return response()->json([
                    'status' => true,
                    'message' => 'Laporan Berhasil Dikirim',
                    'data' => $report
                ]);
            }

            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat menyimpan laporan. Silakan coba lagi.',
            ], 500);


        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error storing report: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat menyimpan laporan. Silakan coba lagi.',
                'error' => $e->getMessage()
            ], 500);
        }
        
    }

    public function uploadFile(Request $request){
        $uploadedFiles = [];
        foreach ($request->file('file') as $file) {
            // Menyimpan file di folder 'uploads' di storage
            $path = $file->store('uploads', 'public');
            $uploadedFiles[] = $path;  // Menyimpan path file untuk referensi
        }

         
        return response()->json([
            'status' => true,
            'data' => $uploadedFiles
        ]);
        
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    private function sendNotificationEmail($data): bool
    {
        try {
            Mail::to('aridalimudin@gmail.com')->send(new NotificationMail($data));
            return true;
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return false; // Failed to send email
        }
    }
}
