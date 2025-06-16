<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class RoomSeeder extends Seeder
{
    public function run(): void
    {
        $rooms = [];

        for ($i = 1; $i <= 10; $i++) {
            $rooms[] = [
                'room_number' => '10' . $i . chr(64 + $i), // 101A, 102B, etc.
                'type' => collect(['Standard', 'Deluxe', 'Suite', 'Presidential'])->random(),
                'status' => 'available',
                'floor' => rand(1, 5),
                'price' => rand(2000, 8000),
                'last_cleaned' => Carbon::now()->subDays(rand(0, 7))->toDateString(),
                'images' => json_encode(["room$i-1.jpg", "room$i-2.jpg"]),
                'features' => json_encode(['WiFi', 'TV', 'AC', 'Mini Bar']),
                'description' => "Sample description for room $i.",
                'capacity' => rand(1, 4),
                'area' => rand(25, 60),
                'bed_type' => collect(['Single', 'Double', 'Queen', 'King'])->random(),
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('rooms')->insert($rooms);
    }
}
