<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassRoom extends Model
{
    use HasFactory;

     protected $fillable = [
        'name',
        'created_by', 
        'updated_by', 
        'deleted_by', 
    ];
}
