<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
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
        'resort_id',
        'is_active',
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
            'is_active' => 'boolean',
        ];
    }

    /**
     * Resort assigned to this user (if resort admin).
     */
    public function resort(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Resort::class);
    }

    /**
     * Determine if the user is an LGU Admin (primary method used throughout the system).
     */
    public function isLguAdmin(): bool
    {
        return $this->role === 'lgu_admin'
            || $this->role === 'super_admin'
            || $this->email === 'admin@gubat.gov.ph';
    }

    /**
     * Alias for isLguAdmin() — kept for backward compatibility.
     */
    public function isSuperAdmin(): bool
    {
        return $this->isLguAdmin();
    }

    /**
     * Determine if the user is a Resort Admin.
     */
    public function isResortAdmin(): bool
    {
        return $this->role === 'resort_admin';
    }
}
