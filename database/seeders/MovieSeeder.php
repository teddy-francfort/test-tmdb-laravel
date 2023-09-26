<?php

namespace Database\Seeders;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Movie::factory()
            ->count(100)
            ->sequence(fn (Sequence $sequence) => [
                'tmdb_id' => $sequence->index + 1,
                'imdb_id' => $sequence->index + 1,
                'title' => 'Movie title '.($sequence->index + 1),
                'overview' => fake()->paragraph(),
                'poster_path' => '/illustration.jpg',
                'data' => [],
            ])
            ->create();
    }
}
