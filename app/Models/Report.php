<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Report extends Model
{
    protected $fillable = [
        'head_of_family_id',
        'title',
        'description',
        'category',
        'status',
        'evidence_image',
        'evidence_images',
        'admin_response',
        'admin_file',
        'responded_at',
    ];

    protected $casts = [
        'evidence_images' => 'array',
        'responded_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function headOfFamily(): BelongsTo
    {
        return $this->belongsTo(HeadOfFamily::class);
    }

    public function resident(): BelongsTo
    {
        return $this->belongsTo(Resident::class);
    }
}
