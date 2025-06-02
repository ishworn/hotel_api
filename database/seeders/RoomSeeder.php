<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        Room::create([
            'room_number' => '101',
            'type' => 'Standard',
            'status' => 'available',
            'floor' => 1,
            'price' => 150,
            'last_cleaned' => now(),
            'images' => json_encode(['/images/room101.jpg']),
            'features' => json_encode(['Wi-Fi', 'TV', 'Air Conditioning', 'Mini Bar']),
            'description' => 'Comfortable standard room with all basic amenities.',
            'capacity' => 2,
            'area' => 28,
            'bed_type' => 'Queen'
        ]);

        Room::create([
            'room_number' => '102',
            'type' => 'Deluxe',
            'status' => 'occupied',
            'floor' => 1,
            'price' => 220,
            'last_cleaned' => now()->subDays(1),
            'images' => json_encode(['/images/room102.jpg']),
            'features' => json_encode(['Wi-Fi', 'TV', 'Jacuzzi', 'Mini Bar']),
            'description' => 'Spacious deluxe room ideal for couples.',
            'capacity' => 3,
            'area' => 35,
            'bed_type' => 'King'
        ]);

        // Add more rooms as needed
    }
}
