<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReporterFile extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'reporter_id',
        'file',
    ];

    protected $appends = [
        'url_file'
    ];

     public function getUrlFileAttribute()
    {
        return asset('storage/'. $this->file);
    }
}
