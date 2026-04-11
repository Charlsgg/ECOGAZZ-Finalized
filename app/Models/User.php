<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',      // Added for Gas Station logic
        'is_active',  // Added for Gas Station logic
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean', // Ensures 1/0 is treated as true/false
        ];
    }

    /**
     * RELATIONSHIP: A user (attendant) has many shifts.
     */
    public function shifts()
    {
        return $this->hasMany(Shift::class);
    }

    /**
     * HELPER: Check if the user is a manager.
     */
    public function isManager(): bool
    {
        return $this->role === 'Manager';
    }
}