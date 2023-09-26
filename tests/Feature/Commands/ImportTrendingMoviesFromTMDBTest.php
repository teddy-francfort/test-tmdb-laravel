<?php

namespace Tests\Feature\Commands;

use App\Models\Movie;
use Tests\TestCase;

class ImportTrendingMoviesFromTMDBTest extends TestCase
{
    /**
     * @test
     */
    public function it_can_import_data(): void
    {
        $this->artisan('tmdb:import-trending-movies')->assertExitCode(0);

        $this->assertEquals(20, Movie::query()->withoutGlobalScopes()->count());
    }

    /**
     * @test
     */
    public function existing_movies_are_updated(): void
    {
        $movie = Movie::factory()->createOne(['tmdb_id' => 820609, 'title' => 'Movie title test']);
        $this->assertEquals(1, Movie::query()->withoutGlobalScopes()->count());

        $this->artisan('tmdb:import-trending-movies')->assertExitCode(0);

        $movie->refresh();
        $this->assertEquals(20, Movie::query()->withoutGlobalScopes()->count());
        $this->assertEquals('No One Will Save You', $movie->title);
        $this->assertEquals('22/09/2023', $movie->release_date->format('d/m/Y'));
    }

    /**
     * @test
     */
    public function an_existing_movies_no_more_trending_day_is_unmarked_as_trending_day(): void
    {
        /** @var Movie $movie */
        $movie = Movie::factory()
            ->trendingDay()
            ->trendingWeek()
            ->createOne(['tmdb_id' => 999999, 'title' => 'Movie title test']);
        $this->assertTrue($movie->is_trending_day);
        $this->assertTrue($movie->is_trending_week);

        $this->artisan('tmdb:import-trending-movies')->assertExitCode(0);

        $movie->refresh();
        $this->assertFalse($movie->is_trending_day);
        $this->assertFalse($movie->is_trending_week);
    }
}
