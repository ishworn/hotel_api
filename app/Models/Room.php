<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = [
        'room_number',
        'type',
        'status',
        'floor',
        'price',
        'last_cleaned',
        'images',
        'features',
        'description',
        'capacity',
        'area',
        'bed_type',
    ];

    protected $casts = [
        'images' => 'array',
        'features' => 'array',
        'last_cleaned' => 'date',
    ];
}
