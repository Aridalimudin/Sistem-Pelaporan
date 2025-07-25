<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Reporter extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'operation_id',
        'code',
        'description',
        'reason',
        'rating',
        'reason_reject',
        'comment',
        'file',
        'urgency',
        'status'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'formatted_urgency',
        'formatted_created_date',
        'formatted_status',
        'formatted_updated_date', 
        'url_file',
        'categories',               
        'categories_type'                
    ];

    public function getCategoriesAttribute()
    {
        // Mengambil semua nama 'crime' yang berelasi dan menggabungkannya 
        // menjadi sebuah string yang dipisahkan oleh koma.
        // Contoh hasil: "Bullying Verbal, Bullying Fisik"
        return $this->crime->pluck('name')->implode(', ');
    }
    public function getCategoriesTypeAttribute()
    {
        // Mengambil semua nama 'crime' yang berelasi dan menggabungkannya 
        // menjadi sebuah string yang dipisahkan oleh koma.
        // Contoh hasil: "Bullying Verbal, Bullying Fisik"
        return $this->crime->pluck('type')->unique()->implode(', ');
    }

    public function getFormattedUrgencyAttribute()
    {
        if($this->urgency == 1){
            $urgency = '<span class="text-info">Rendah</span>';
        }elseif($this->urgency == 2){
            $urgency = '<span class="text-warning">Sedang</span>';
        }elseif($this->urgency == 3){
            $urgency = '<span class="text-danger">Tinggi</span>';
        }else{
            $urgency = '-';
        }

        return $urgency;
    }
    public function getFormattedStatusAttribute()
    {
        if($this->status == 0){
            $status = '<span class="text-info">Menunggu Approval</span>';
        }elseif($this->status == 1){
            $status = '<span class="text-warning">Menunggu Kelengkapan Data</span>';
        }elseif($this->status == 2){
            $status = '<span class="text-primary">Proses</span>';
        }elseif($this->status == 3){
            $status = '<span class="text-success">Selesai</span>';
        }elseif($this->status == 4){
            $status = '<span class="text-danger">Reject</span>';
        }else{
            $status = '-';
        }

        return $status;
    }

    public function getFormattedCreatedDateAttribute()
    {
        return $this->created_at ? $this->created_at->format('d F Y, H:i') : '-';
    }

    // ==========================================================
    // == FUNGSI BARU DITAMBAHKAN DI SINI ==
    // ==========================================================
    public function getFormattedUpdatedDateAttribute()
    {
        return $this->updated_at->format('d F Y');
    }

    public function getUrlFileAttribute()
    {
        if ($this->file) {
            return asset('storage/' . $this->file);
        }
        return null;
    }
    // ==========================================================

    /**
     * Get the studen that owns the Reporter
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
    
    /**
     * Get the studen that owns the Reporter
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function operation(): BelongsTo
    {
        return $this->belongsTo(Operation::class);
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

    /**
     * Get all of the comments for the Reporter
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function reporterHistory(): HasMany
    {
        return $this->hasMany(ReporterHistoryTracking::class);
    }

    /**
     * Get all of the comments for the Reporter
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function reporterDetail(): HasOne
    {
        return $this->hasOne(ReporterDetail::class);
    }
}