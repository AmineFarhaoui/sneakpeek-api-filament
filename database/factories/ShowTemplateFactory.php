<?php

namespace Database\Factories;

use App\Library\Enumerations\ShowTemplateAlignment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ShowTemplate>
 */
class ShowTemplateFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->sentence(3),
            'message_alignment' => $this->faker->randomElement(ShowTemplateAlignment::getValues()),
        ];
    }
}
