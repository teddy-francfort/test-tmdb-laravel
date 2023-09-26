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
            ->assertRedirect();
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
}
