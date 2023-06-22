<?php

namespace Database\Factories;

use App\Library\Enumerations\ScheduledMessageAlignment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Actor>
 */
class ActorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'user_id' => $this->faker->randomElement([null, User::factory()]),
            'alignment' => $this->faker->randomElement(ScheduledMessageAlignment::getValues()),
        ];
    }
}
