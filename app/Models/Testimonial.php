<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'visitor_name', 'visitor_role', 'content', 'rating', 'image_url'
    ];
}
