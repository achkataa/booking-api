<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $type = $this->faker->randomElement(['big', 'tiny', 'normal']);
        $status = $this->faker->randomElement(['available', 'occupied']);

        return [
            'number' => $this->faker->unique()->numberBetween(1, 11),
            'type' => $type,
            'price_per_night' => $this->faker->numberBetween(100, 500),
            'status' => $status,
        ];
    }
}
