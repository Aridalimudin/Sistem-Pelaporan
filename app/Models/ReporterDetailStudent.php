<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReporterDetailStudent extends Model
{
    use HasFactory;
     protected $fillable = [
        'reporter_detail_id',
        'student_id',
        'type',
    ];

}
