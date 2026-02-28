<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'aktif',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'aktif' => 'boolean',
        'password' => 'hashed',
    ];

    /**
     * Relasi ke data karyawan (opsional)
     */
    public function karyawan()
    {
        return $this->hasOne(Karyawan::class);
    }

    /**
     * Check if user has specific role
     */
    public function hasRole($role)
    {
        return $this->karyawan && $this->karyawan->role === $role;
    }
}
