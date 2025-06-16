<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
   protected $fillable = [
  'room_number', 'floor', 'type', 'bed_type',
  'price', 'capacity', 'area', 'description',
  'features', 'status', 'image'
];

protected $casts = [
  'features' => 'array',
];
}
