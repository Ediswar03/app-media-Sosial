<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostAttachment extends Model
{
    protected $fillable = [
        'post_id',
        'path',
        'mime_type',
    ];

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
