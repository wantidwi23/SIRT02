<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'active',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the user's associated resident profile.
     */
    public function resident()
    {
        return $this->hasOne(Resident::class);
    }

    /**
     * Get the user's reports through resident relationship.
     */
    public function reports()
    {
        return $this->hasManyThrough(
            Report::class,
            Resident::class,
            'user_id', // Foreign key on residents table
            'resident_id' // Foreign key on reports table
        );
    }

    /**
     * Get the user's letters through resident relationship.
     */
    public function letters()
    {
        return $this->hasManyThrough(
            Letter::class,
            Resident::class,
            'user_id', // Foreign key on residents table
            'resident_id' // Foreign key on letters table
        );
    }

    /**
     * Check if user is admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is regular user.
     */
    public function isUser(): bool
    {
        return $this->role === 'user';
    }
}

