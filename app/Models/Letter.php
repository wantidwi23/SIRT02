<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Letter extends Model
{
    protected $fillable = [
        'applicant_name',
        'applicant_nik',
        'identity_image',
        'letter_category_id',
        'purpose',
        'notes',
        'status',
        'ready_at',
        'taken_at',
        'admin_notes',
        'letter_file',
        'head_of_family_id',
    ];

    protected $casts = [
        'ready_at' => 'datetime',
        'taken_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function resident(): BelongsTo
    {
        return $this->belongsTo(Resident::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(LetterCategory::class, 'letter_category_id');
    }
}

