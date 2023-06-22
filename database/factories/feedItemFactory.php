<?php

namespace Database\Factories;

use App\Library\Enumerations\FeedItemType;
use App\Models\Show;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\feedItem>
 */
class feedItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->randomElement(FeedItemType::getKeys()),
            'show_id' => Show::factory(),
            'has_live_moment' => $this->faker->boolean,
            'is_coming_soon' => $this->faker->boolean,
        ];
    }
}
