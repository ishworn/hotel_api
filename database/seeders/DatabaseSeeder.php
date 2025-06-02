<?php

namespace Database\Seeders;

use App\Models\Room;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
         $this->call([
        CustomerSeeder::class,
       
        RoomSeeder::class,
        IPListSeeder::class,
        RoleSeeder::class,  // Add other seeder classes here
        // Add more as needed
    ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
