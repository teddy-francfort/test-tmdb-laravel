<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tmdb_id' => fake()->unique()->randomNumber(5),
            'imdb_id' => uniqid(),
            'title' => 'The Lord of the Rings: The Two Towers',
            'release_date' => '2002-12-18',
            'overview' => 'Frodo and Sam are trekking to Mordor to destroy the One Ring of Power while Gimli, Legolas and Aragorn search for the orc-captured Merry and Pippin. All along, nefarious wizard Saruman awaits the Fellowship members at the Orthanc Tower in Isengard.',
            'poster_path' => '/5VTN0pR8gcqV3EPUHHfMGnJYN9L.jpg',
            'is_trending_day' => false,
            'is_trending_week' => false,
            'data' => [],
        ];
    }

    /**
     * Indicate that the movie is trending for the day.
     */
    public function trendingDay(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'is_trending_day' => true,
            ];
        });
    }

    /**
     * Indicate that the movie is trending for the day.
     */
    public function trendingWeek(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'is_trending_week' => true,
            ];
        });
    }
}
