<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute; // Tambahkan ini untuk fitur Mutator

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'body',
    ];

    // --- MUTATORS (PERBAIKAN UTAMA) ---

    /**
     * Memastikan kolom 'body' tidak pernah bernilai NULL.
     * Jika sistem mencoba menyimpan NULL, otomatis diubah jadi string kosong "".
     */
    protected function body(): Attribute
    {
        return Attribute::make(
            set: fn ($value) => $value ?? '',
        );
    }

    // --- RELATIONSHIPS ---

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function attachments()
    {
        // PERBAIKAN: Disamakan dengan Controller (Attachment::class), bukan PostAttachment::class
        return $this->hasMany(Attachment::class);
    }

    // --- HELPERS ---

    public function isLikedBy(User $user): bool
    {
        // Tips: Menggunakan $this->relationLoaded meminimalisir query berulang jika data sudah di-eager load
        if ($this->relationLoaded('likes')) {
            return $this->likes->contains('user_id', $user->id);
        }

        return $this->likes()
            ->where('user_id', $user->id)
            ->exists();
    }
}