<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReporterDetail extends Model
{
    use HasFactory;

     protected $fillable = [
        'reporter_id',
        'report_date',
        'location',
        'notes_by_student',
        'description',
    ];

    protected $appends = [
       'formatted_report_date'
    ];

    public function getFormattedReportDateAttribute()
    {
        return $this->report_date ? Carbon::parse($this->report_date)->format('d F Y, H:i') : '-';
    }

    public function victims()
    {
        return $this->belongsToMany(Student::class, 'reporter_detail_students', 'reporter_detail_id', 'student_id')
                    ->wherePivot('type', 'Korban');
    }

     public function perpetrators()
    {
        return $this->belongsToMany(Student::class, 'reporter_detail_students', 'reporter_detail_id', 'student_id')
                    ->wherePivot('type', 'Pelaku');
    }

     public function witnesses()
    {
        return $this->belongsToMany(Student::class, 'reporter_detail_students', 'reporter_detail_id', 'student_id')
                    ->wherePivot('type', 'Saksi');
    }
}
