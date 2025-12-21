<?php

namespace App\Models;

use Illuminate\Notifications\DatabaseNotification;

class Notification extends DatabaseNotification
{
    // Relationship dengan user yang menerima notifikasi
    public function user()
    {
        return $this->belongsTo(User::class, 'notifiable_id');
    }

    // Polymorphic relationship dengan model yang menyebabkan notifikasi
    public function notifiable()
    {
        return $this->morphTo();
    }

    // Scope untuk notifikasi yang belum dibaca
    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    // Scope untuk notifikasi yang sudah dibaca
    public function scopeRead($query)
    {
        return $query->whereNotNull('read_at');
    }

    // Method untuk menandai notifikasi sebagai sudah dibaca
    public function markAsRead()
    {
        if (is_null($this->read_at)) {
            $this->update(['read_at' => now()]);
            return true;
        }
        return false;
    }

    // Method untuk menandai notifikasi sebagai belum dibaca
    public function markAsUnread()
    {
        $this->update(['read_at' => null]);
        return true;
    }

    // Method untuk mendapatkan pesan notifikasi berdasarkan tipe
    public function getMessageAttribute()
    {
        $data = $this->data ?? [];

        switch ($this->type) {
            case 'like':
                return $data['user_name'] . ' menyukai postingan Anda';
            case 'comment':
                return $data['user_name'] . ' mengomentari postingan Anda';
            case 'follow':
                return $data['user_name'] . ' mulai mengikuti Anda';
            case 'mention':
                return $data['user_name'] . ' menyebut Anda dalam postingan';
            case 'reply':
                return $data['user_name'] . ' membalas komentar Anda';
            case 'story_like':
                return $data['user_name'] . ' menyukai story Anda';
            case 'story_comment':
                return $data['user_name'] . ' mengomentari story Anda';
            case 'new_post':
                return $data['user_name'] . ' membuat postingan baru';
            case 'profile_photo_update':
                return $data['user_name'] . ' memperbarui foto profil';
            case 'cover_photo_update':
                return $data['user_name'] . ' memperbarui foto sampul';
            default:
                return 'Anda memiliki notifikasi baru';
        }
    }

    // Method untuk mendapatkan URL tujuan notifikasi
    public function getUrlAttribute()
    {
        $data = $this->data ?? [];

        switch ($this->type) {
            case 'like':
            case 'comment':
            case 'mention':
                return route('posts.show', $data['post_id'] ?? '');
            case 'follow':
                return route('profile.show', $data['follower_id'] ?? '');
            case 'reply':
                return route('posts.show', $data['post_id'] ?? '') . '#comment-' . ($data['comment_id'] ?? '');
            case 'story_like':
            case 'story_comment':
                return route('stories.show', $data['story_id'] ?? '');
            case 'new_post':
                return route('posts.show', $data['post_id'] ?? '');
            case 'profile_photo_update':
            case 'cover_photo_update':
                return route('profile.index', $data['user_id'] ?? '');
            default:
                return '#';
        }
    }
}
