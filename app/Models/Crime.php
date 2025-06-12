<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crime extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'urgency',
        'created_by', 
        'updated_by', 
        'deleted_by', 
    ];
}