<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


// Model ini sekarang hanya untuk admin panel
class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    // Kolom yang dapat diisi untuk admin
    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // pastikan ada kolom role di database
    ];

    // Kolom yang disembunyikan saat serialisasi
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Casting kolom
    protected $casts = [
        'password' => 'hashed',
    ];
}
