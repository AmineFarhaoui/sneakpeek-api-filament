<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (app()->environment(['production', 'testing'])) {
            return;
        }

        Genre::factory()->create([
            'name' => 'Comedy',
        ]);

        Genre::factory()->create([
            'name' => 'Drama',
        ]);

        Genre::factory()->create([
            'name' => 'Horror',
        ]);
    }
}
