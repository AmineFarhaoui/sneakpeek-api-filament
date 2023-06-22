<?php

namespace Database\Factories;

use App\Models\ShowTemplate;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Conversation>
 */
class ConversationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'show_template_id' => ShowTemplate::factory()->hasShowTemplateMessages(25),
            'external_url' => $this->faker->url,
            'starting_date' => $this->faker->dateTimeBetween('-1 week', '+1 week'),
            'is_preview' => $this->faker->boolean,
        ];
    }
}
