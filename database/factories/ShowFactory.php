<?php

namespace Database\Factories;

use App\Models\Show;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Show>
 */
class ShowFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->sentence(4),
            'description' => $this->faker->paragraph,
            'price' => $this->faker->randomFloat(2, 0, 100),
            'transaction_costs' => $this->faker->randomFloat(2, 0, 100),
            'cast' => $this->faker->name.', '.$this->faker->name,
            'creators' => $this->faker->name.', '.$this->faker->name,
            'introduction_texts' => json_encode([
                $this->faker->paragraph,
                $this->faker->paragraph,
            ]),
            'share_url' => $this->faker->url,
            'share_text' => $this->faker->sentence,
            'preview_token' => $this->faker->uuid,
        ];
    }
}
