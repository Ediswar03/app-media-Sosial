<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Pastikan kolom expires_at dibaca sebagai tanggal oleh Laravel
    protected $casts = [
        'expires_at' => 'datetime',
    ];

    // Relasi ke User (Pembuat Story)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}