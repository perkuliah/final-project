<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'description',
        'status',
        'assigned_to',
        'due_date',
        'attachment',        // file dari admin
        'submission',        // file dari user
        'completed_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'status' => 'string',
        'due_date' => 'datetime',
        'completed_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $appends = ['submission_url'];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /**
     * Tugas ditugaskan kepada satu user.
     */
    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS (for UI / Blade)
    |--------------------------------------------------------------------------
    */

    /**
     * Label status dalam Bahasa Indonesia.
     */
    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'pending' => 'Menunggu',
            'in_progress' => 'Dikerjakan',
            'completed' => 'Selesai',
            default => 'Tidak Diketahui',
        };
    }

    /**
     * Kelas CSS badge sesuai Soft UI Dashboard.
     */
    public function getStatusBadgeClassAttribute()
    {
        return match ($this->status) {
            'pending' => 'bg-warning text-dark',
            'in_progress' => 'bg-info',
            'completed' => 'bg-success',
            default => 'bg-secondary',
        };
    }

    /**
     * URL publik untuk lampiran dari admin.
     */
    public function getAttachmentUrlAttribute()
    {
        return $this->attachment ? Storage::url($this->attachment) : null;
    }

    /**
     * URL publik untuk hasil tugas dari user.
     */


public function getSubmissionUrlAttribute()
{
    if ($this->submission) {
        return asset('storage/' . $this->submission);
    }
    return null;
}
}
