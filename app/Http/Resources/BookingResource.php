<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BookingResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'booking_reference' => $this->booking_reference,
            'guests'            => $this->guests,
         
            'room_rate'         => number_format($this->room_rate, 2),
      
            'nights'            => $this->nights,
            'total_amount'      => number_format($this->total_amount, 2),
            'customer'          => [
                'id'    => $this->customer->id ?? null,
                'name'  => $this->customer->name ?? null,
                'email' => $this->customer->email ?? null,
                'phone' => $this->customer->phone ?? null,
            ],
            'created_at' => $this->created_at->diffForHumans(),
            'room' => [
                'id'   => $this->room->id,
                'name' => $this->room->name,
                'type' => $this->room->type,
            ],
        ];
    }
}
