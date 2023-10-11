<?php

namespace Tests\Feature\Movies;

use App\Livewire\Movies\ShowMovies;
use App\Models\Movie;
use App\Models\User;
use Database\Seeders\MovieSeeder;
use Livewire\Livewire;
use Tests\TestCase;

class ShowMoviesTest extends TestCase
{
    /** @test */
    public function guest_cannot_access_the_route(): void
    {
        $this->get(route('movies.index'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function authenticated_user_can_access_the_route(): void
    {
        $user = User::factory()->createOne();

        $this->actingAs($user);

        $this->get(route('movies.index'))
            ->assertOk();
    }

    /** @test */
    public function authenticated_user_can_access_the_page(): void
    {
        Movie::factory()->createOne(['title' => 'Movie title 1']);
        Movie::factory()->createOne(['title' => 'Movie title 2']);

        $user = User::factory()->createOne();

        $this->actingAs($user);

        Livewire::test(ShowMovies::class)
            ->set('perPage', 10)
            ->assertOk()->assertSeeInOrder([
                'Movie title 2',
                'Movie title 1',
            ]);
    }

    /** @test */
    public function trashed_movies_are_displayed(): void
    {
        Movie::factory()->trashed()->createOne(['title' => 'Movie title']);
        $user = User::factory()->createOne();

        $this->actingAs($user);

        Livewire::test(ShowMovies::class)
            ->set('perPage', 10)
            ->assertOk()
            ->assertSee('Movie title');
    }

    /** @test */
    public function pagination_works(): void
    {
        Movie::factory()->createOne(['title' => 'Movie test 1']);
        $this->seed(MovieSeeder::class);
        Movie::factory()->createOne(['title' => 'Last movie created']);

        $user = User::factory()->createOne();

        $this->actingAs($user);

        Livewire::test(ShowMovies::class)
            ->set('perPage', 10)
            ->assertOk()
            ->assertSee('Last movie created')
            ->assertDontSee('Movie test 1')
            ->assertViewHas('movies', function ($movies) {
                $this->assertCount(10, $movies);

                return true;
            });
    }

    /** @test */
    public function movies_can_be_searched(): void
    {
        Movie::factory()->trendingDay()->createOne(['title' => 'Movie trending 123']);
        /** @var Movie $foundMovie1 */
        $foundMovie1 = Movie::factory()->trendingDay()->createOne(['title' => 'Movie trending 456']);
        Movie::factory()->createOne(['title' => 'Movie not trending 123']);
        /** @var Movie $foundMovie2 */
        $foundMovie2 = Movie::factory()->createOne(['title' => 'Movie not trending 456']);

        Livewire::test(ShowMovies::class, ['timeWindow' => 'day'])
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
