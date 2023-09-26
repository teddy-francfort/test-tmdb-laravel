<?php

namespace Tests\Feature\Repositories;

use App\Repositories\TmdbRepositoryApi;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class TmdbRepositoryApiTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Http::preventStrayRequests();
    }

    /** @test */
    public function it_gets_trending_day_movies(): void
    {
        Http::fake([
            '*trending/movie/day' => Http::response(Storage::disk('test')->get('Feature/Repositories/fixtures/trending_movie.json')),
        ]);
        $repository = new TmdbRepositoryApi();

        $movies = $repository->getTrendingMovies('day');

        $this->assertCount(20, $movies);
    }

    /** @test */
    public function it_gets_trending_week_movies(): void
    {
        Http::fake([
            '*trending/movie/week' => Http::response(Storage::disk('test')->get('Feature/Repositories/fixtures/trending_movie.json')),
        ]);
        $repository = new TmdbRepositoryApi();

        $movies = $repository->getTrendingMovies('week');

        $this->assertCount(20, $movies);
    }

    /** @test */
    public function it_gets_a_movie_details(): void
    {
        Http::fake([
            '*movie/121' => Http::response(Storage::disk('test')->get('Feature/Repositories/fixtures/movie_121.json')),
        ]);
        $repository = new TmdbRepositoryApi();

        $movie = $repository->getMovieDetails(121);

        $this->assertEquals(121, $movie->tmdb_id);
        $this->assertEquals('The Lord of the Rings: The Two Towers', $movie->title);
        $this->assertEquals(
            'Frodo and Sam are trekking to Mordor to destroy the One Ring of Power while Gimli, Legolas and Aragorn search for the orc-captured Merry and Pippin. All along, nefarious wizard Saruman awaits the Fellowship members at the Orthanc Tower in Isengard.',
            $movie->overview);
    }
}
