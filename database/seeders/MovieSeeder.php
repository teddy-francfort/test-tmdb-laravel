<?php

namespace Database\Seeders;

use App\Models\Movie;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $release_date = CarbonImmutable::now();
        Movie::factory()
            ->count(100)
            ->sequence(fn (Sequence $sequence) => [
                'tmdb_id' => $sequence->index + 1,
                'imdb_id' => $sequence->index + 1,
                'title' => 'Movie title '.($sequence->index + 1),
                'overview' => fake()->paragraph(),
                'poster_path' => '/illustration.jpg',
                'release_date' => $release_date->subYears(3)->addDays($sequence->index)->format('Y-m-d'),
                'data' => [],
            ])
            ->create();

        Movie::factory()
            ->trendingDay()
            ->count(20)
            ->sequence(fn (Sequence $sequence) => [
                'tmdb_id' => $sequence->index + 100,
                'imdb_id' => $sequence->index + 100,
                'title' => 'Movie trending day '.($sequence->index + 100),
                'overview' => fake()->paragraph(),
                'poster_path' => '/illustration.jpg',
                'release_date' => $release_date->subYears(2)->addDays($sequence->index)->format('Y-m-d'),
                'data' => [],
            ])
            ->create();

        Movie::factory()
            ->trendingWeek()
            ->count(20)
            ->sequence(fn (Sequence $sequence) => [
                'tmdb_id' => $sequence->index + 200,
                'imdb_id' => $sequence->index + 200,
                'title' => 'Movie trending week '.($sequence->index + 200),
                'overview' => fake()->paragraph(),
                'poster_path' => '/illustration.jpg',
                'release_date' => $release_date->subYears(1)->addDays($sequence->index)->format('Y-m-d'),
                'data' => [],
            ])
            ->create();
    }
}
