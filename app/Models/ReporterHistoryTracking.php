<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReporterHistoryTracking extends Model
{
    use HasFactory;
     protected $fillable = [
        'reporter_id',
        'status',
        'username',
        'description',
    ];

    protected $appends = [
        'formatted_status'
    ];

     public function getFormattedStatusAttribute()
    {
        if($this->status == 0){
            $status = '<span class="text-info">Menunggu Approval</span>';
        }elseif($this->status == 1){
            $status = '<span class="text-success">Approve</span>';
        }elseif($this->status == 2){
            $status = '<span class="text-danger">Reject</span>';
        }else{
            $status = '-';
        }

        return $status;
    }
}
