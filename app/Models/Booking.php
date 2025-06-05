<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

  protected $fillable = [
    'customer_id',
    'guests',
    'room_id',
    'room_type',
    'room_rate',
    'check_in',
    'check_out',
    'nights',
    'total_amount',
    'room_number',
    'booking_reference', // ✅ add this
];


public function customer()
{
    return $this->belongsTo(Customer::class);
}

}
