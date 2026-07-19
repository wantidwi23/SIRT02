<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class HeadOfFamily extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'nama',
        'alamat',
        'email',
        'password',
        'active',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'active' => 'boolean',
        'password' => 'hashed',
    ];
}

