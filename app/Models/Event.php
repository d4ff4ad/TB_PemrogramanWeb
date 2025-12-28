<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    // Masukkan nama-nama kolom tabel kamu di sini agar bisa di-input
    protected $fillable = [
        'title',
        'description',
        'banner_image',
        'start_time',
        'end_time',
        'location',
        'quota',
        'price',
    ];
    
    
    // Opsional: Casting agar data tanggal otomatis jadi objek Carbon (mudah diformat)
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }
}