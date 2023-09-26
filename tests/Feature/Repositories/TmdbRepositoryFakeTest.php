<?php

namespace Tests\Feature\Repositories;

use App\Repositories\TmdbRepositoryFake;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class TmdbRepositoryFakeTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Http::preventStrayRequests();
    }

    /** @test */
    public function it_gets_trending_day_movies(): void
    {
        $repository = new TmdbRepositoryFake();

        $movies = $repository->getTrendingMovies('day');

        $this->assertCount(20, $movies);
    }

    /** @test */
    public function it_gets_trending_week_movies(): void
    {
        $repository = new TmdbRepositoryFake();

        $movies = $repository->getTrendingMovies('week');

        $this->assertCount(20, $movies);
    }

    /** @test */
    public function it_gets_a_movie_details(): void
    {
        $repository = new TmdbRepositoryFake();

        $movie = $repository->getMovieDetails(121);

        $this->assertEquals(121, $movie->tmdb_id);
        $this->assertEquals('18/12/2002', $movie->release_date->format('d/m/Y'));
        $this->assertEquals('The Lord of the Rings: The Two Towers', $movie->title);
        $this->assertEquals(
            'Frodo and Sam are trekking to Mordor to destroy the One Ring of Power while Gimli, Legolas and Aragorn search for the orc-captured Merry and Pippin. All along, nefarious wizard Saruman awaits the Fellowship members at the Orthanc Tower in Isengard.',
            $movie->overview);
    }

    /** @test */
    public function it_gets_the_configuration(): void
    {
        $repository = new TmdbRepositoryFake();

        $configuration = $repository->getConfiguration();

        $this->assertEquals('http://image.tmdb.org/t/p/', $configuration->base_url);
        $this->assertEquals('https://image.tmdb.org/t/p/', $configuration->secure_base_url);
        $this->assertEquals(['w92', 'w154', 'w185', 'w342', 'w500', 'w780', 'original'], $configuration->poster_sizes);
    }
}
