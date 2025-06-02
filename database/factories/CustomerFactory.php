<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'full_name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'phone' => $this->faker->phoneNumber,
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'address' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'country' => $this->faker->country,
            'postal_code' => $this->faker->postcode,
            'notes' => $this->faker->sentence,
            'document' => null, // You can update this if you're simulating file uploads
        ];
    }
}
