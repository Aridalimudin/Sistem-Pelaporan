<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Reporter extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'code',
        'description',
        'urgency',
    ];

    /**
     * Get the studen that owns the Reporter
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function crime()
    {
        return $this->belongsToMany(Crime::class, 'reporter_crimes');
    }

    /**
     * Get all of the comments for the Reporter
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reporterFile(): HasMany
    {
        return $this->hasMany(ReporterFile::class);
    }
}
