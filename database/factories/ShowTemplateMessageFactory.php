<?php

namespace Database\Factories;

use App\Models\Actor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ShowTemplateMessage>
 */
class ShowTemplateMessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'actor_id' => Actor::inRandomOrder()->first()->id,
            'system_message' => $this->faker->boolean,
            'week' => $this->faker->numberBetween(1, 4),
            'day' => $this->faker->numberBetween(1, 7),
            'time' => $this->faker->time(),
            'message' => $this->faker->sentence,
        ];
    }
}
