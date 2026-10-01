<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeatherTip extends Model
{
    protected $fillable = [
        'title', 'content', 'icon_class'
    ];
}
