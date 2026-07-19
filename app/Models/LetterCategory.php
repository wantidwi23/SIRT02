<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LetterCategory extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
    ];

    public function letters(): HasMany
    {
        return $this->hasMany(Letter::class);
    }
}
