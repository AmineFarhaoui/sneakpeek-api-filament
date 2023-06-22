<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LoginAttemptFactory extends Factory
{
    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'email' => $this->faker->safeEmail,
            'user_id' => null,
            'ip_address' => $this->faker->ipv4,
            'user_agent' => $this->faker->userAgent,
            'success' => $this->faker->boolean,
            'suspicious' => $this->faker->boolean,
        ];
    }
}
