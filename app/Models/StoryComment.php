<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoryComment extends Model
{
    use HasFactory;
    
    protected $guarded = ['id']; // Izinkan semua kolom diisi

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}