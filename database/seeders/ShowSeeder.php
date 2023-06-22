<?php

namespace Database\Seeders;

use App\Models\Actor;
use App\Models\Conversation;
use App\Models\FeedItem;
use App\Models\Genre;
use App\Models\Show;
use Illuminate\Database\Seeder;

class ShowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Actor::factory()->count(10)->create();

        Show::factory()
            ->has(
                Genre::factory()
                    ->state(function (array $attributes, Show $show) {
                        return ['name' => 'erotica'];
                    }),
            )
            ->has(FeedItem::factory())
            ->has(Conversation::factory()->count(2))
            ->create([
                'name' => "Amine's Erotic Adventures",
                'cast' => 'Willy Wonka, Charlie Bucket',
                'creators' => 'Sexual Chocolate',
            ]);

        Show::factory()
            ->count(10)
            ->has(Genre::factory()->count(3))
            ->has(FeedItem::factory())
            ->has(Conversation::factory()->count(2))
            ->create();
    }
}
