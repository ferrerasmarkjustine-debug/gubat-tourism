<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Craft extends Model
{
    protected $fillable = [
        'name',
        'category_slug',
        'category_name',
        'description',
        'highlight',
        'products',
        'image_url',
        'address',
        'barangay',
        'google_map_url',
        'contact',
        'badge_color',
        'is_featured',
        'gallery_images',
    ];

    protected $casts = [
        'products' => 'array',
        'gallery_images' => 'array',
        'is_featured' => 'boolean',
    ];
}
