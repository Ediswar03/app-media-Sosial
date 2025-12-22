<?php

// app/Models/Attachment.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $fillable = ['post_id', 'path', 'mime_type'];

    // Accessor for attachment URL
    public function getAttachmentUrlAttribute(): ?string
    {
        if ($this->path) {
            return route('attachment.serve', ['path' => $this->path]);
        }
        return null; // Or a placeholder image URL if preferred
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
