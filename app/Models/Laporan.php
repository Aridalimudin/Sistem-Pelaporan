<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporan';

    protected $fillable = [
        'id_laporan',
        'nis', // Field baru menggantikan nama_pelapor
        'email', // Field baru menggantikan telepon
        'uraian',
        'tanggal_lapor',
        'status',
        'bukti_file', // Pastikan field untuk menyimpan path file bukti ada
        'catatan_verifikasi',
        'tanggal_verifikasi',
        'status_terakhir',
        'orang_penindak',
        'alasan_history',
        'catatan_history',
        'user_id',
        'updated_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}