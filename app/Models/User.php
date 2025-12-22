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
        'username',
        'email',
        'password',
        'role',
        'avatar',
        'cover_image',
        'bio',
        'address',
        'phone',
        'pekerjaan',
        'education',
        'location',
        'job_title',
        'company',
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
            return route('user.avatar', ['path' => $this->avatar]);
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
            return route('user.cover', ['path' => $this->cover_image]);
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
    // Tambahkan Relasi & Helper di User.php

public function followers()
{
    // Relasi many-to-many ke user lain (sebagai pengikut)
    return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');
}

public function isFollowedBy(User $user)
{
    // Cek apakah user ini sudah diikuti oleh $user (login user)
    return $this->followers()->where('follower_id', $user->id)->exists();
}
public function stories()
{
    return $this->hasMany(Story::class);
}

public function sentMessages()
{
    return $this->hasMany(Message::class, 'sender_id');
}

public function receivedMessages()
{
    return $this->hasMany(Message::class, 'receiver_id');
}

public function messages()
{
    return Message::where('sender_id', $this->id)
        ->orWhere('receiver_id', $this->id)
        ->orderBy('created_at', 'desc');
}
}