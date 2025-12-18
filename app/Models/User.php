<?php

namespace App\Models;

// Import class yang diperlukan untuk Type Hinting
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Models\User;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Atribut yang bisa diisi secara massal.
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
        'cover_image',
        'bio',
    ];

    /**
     * Atribut yang disembunyikan saat serialisasi (misal: return JSON API).
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Konversi tipe data otomatis.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ==========================================
    // CUSTOM ACCESSORS (PENTING UNTUK SOSMED)
    // ==========================================

    /**
     * Mendapatkan URL lengkap avatar.
     * Cara pakai di view: {{ $user->avatar_url }}
     */
    public function getAvatarUrlAttribute()
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }

        // Jika user belum punya avatar, gunakan inisial nama (UI Avatars)
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF';
    }

    /**
     * Mendapatkan URL lengkap cover image.
     * Cara pakai di view: {{ $user->cover_url }}
     */
    public function getCoverUrlAttribute()
    {
        if ($this->cover_image) {
            return asset('storage/' . $this->cover_image);
        }

        // Gambar default/placeholder jika tidak ada cover
        return asset('images/default-cover.jpg'); 
    }

    // ==========================================
    // RELATIONSHIPS
    // ==========================================
    
    public function posts(): HasMany
    {
        // Menambahkan 'latest()' agar post terurut dari yang terbaru
        return $this->hasMany(Post::class)->latest();
    }

    // ==========================================
    // ROLE CHECKS
    // ==========================================
    
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }
}