<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ScheduledMessage>
 */
class ScheduledMessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'conversation_id' => \App\Models\Conversation::factory(),
            'show_template_message_id' => \App\Models\ShowTemplateMessage::factory(),
            'actor_id' => \App\Models\Actor::factory(),
            'send_at' => $this->faker->dateTimeBetween('-1 week', '+1 week'),
            'alignment' => $this->faker->randomElement([0, 1]),
        ];
    }
}
