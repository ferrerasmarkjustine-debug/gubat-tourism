<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
    protected $fillable = [
        'title', 'content', 'category', 'image_url', 'published_at'
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];
}
