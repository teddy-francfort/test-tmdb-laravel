<?php

namespace Tests\Feature\Movies;

use App\Livewire\Movies\ShowTrendingMovies;
use App\Models\Movie;
use App\Models\User;
use Livewire\Livewire;
use Tests\TestCase;

class ShowTrendingMoviesTest extends TestCase
{
    /** @test */
    public function guest_can_access_the_route(): void
    {
        $this->get(route('trending.movies.index', ['timeWindow' => 'day']))
            ->assertOk();

        $this->get(route('trending.movies.index', ['timeWindow' => 'week']))
            ->assertOk();
    }

    /** @test */
    public function unknown_time_window_returns_not_found(): void
    {
        $this->get(route('trending.movies.index', ['timeWindow' => 'unknown']))
            ->assertNotFound();
    }

    /** @test */
    public function authenticated_user_can_access_the_route(): void
    {
        $user = User::factory()->createOne();

        $this->actingAs($user);

        $this->get(route('trending.movies.index', ['timeWindow' => 'day']))
            ->assertOk();

        $this->get(route('trending.movies.index', ['timeWindow' => 'week']))
            ->assertOk();
    }

    /** @test */
    public function it_shows_only_trending_day_movies(): void
    {
        Movie::factory()->trendingDay()->createOne(['title' => 'Movie trending day']);
        Movie::factory()->createOne(['title' => 'Movie not trending']);

        Livewire::test(ShowTrendingMovies::class, ['timeWindow' => 'day'])
            ->set('perPage', 10)
            ->assertOk()
            ->assertSee('Movie trending day')
            ->assertDontSee('Movie not trending');
    }

    /** @test */
    public function it_shows_only_trending_week_movies(): void
    {
        Movie::factory()->trendingWeek()->createOne(['title' => 'Movie trending week']);
        Movie::factory()->createOne(['title' => 'Movie not trending']);

        Livewire::test(ShowTrendingMovies::class, ['timeWindow' => 'week'])
            ->set('perPage', 10)
            ->assertOk()
            ->assertSee('Movie trending week')
            ->assertDontSee('Movie not trending');
    }

    /** @test */
    public function movies_can_be_searched(): void
    {
        Movie::factory()->trendingDay()->createOne(['title' => 'Movie trending 123']);
        /** @var Movie $foundMovie1 */
        $foundMovie1 = Movie::factory()->trendingDay()->createOne(['title' => 'Movie trending 456']);
        /** @var Movie $foundMovie2 */
        $foundMovie2 = Movie::factory()->trendingDay()->createOne(['title' => 'Movie trending 4567']);
        Movie::factory()->createOne(['title' => 'Movie not trending 123']);
        Movie::factory()->createOne(['title' => 'Movie not trending 456']);

        Livewire::test(ShowTrendingMovies::class, ['timeWindow' => 'day'])
            ->set('search', '56')
            ->set('perPage', 10)
            ->assertOk()
            ->assertViewHas('movies', function ($movies) use ($foundMovie1, $foundMovie2) {
                $this->assertCount(2, $movies);
                $this->assertContains($foundMovie1->getKey(), $movies->pluck('id'));
                $this->assertContains($foundMovie2->getKey(), $movies->pluck('id'));

                return true;
            });
    }
}
