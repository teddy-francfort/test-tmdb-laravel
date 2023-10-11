<?php

namespace Tests\Feature\Movies;

use App\Livewire\Movies\ShowMovie;
use App\Models\Movie;
use App\Models\User;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class ShowMovieTest extends TestCase
{
    #[Test]
    public function guest_cannot_access_a_trashed_movie(): void
    {
        $movie = Movie::factory()->trashed()->createOne(['title' => 'Movie title']);

        $this->get(route('movies.show', ['movie' => $movie]))
            ->assertForbidden();
    }

    #[Test]
    public function authenticated_user_can_access_a_trashed_movie(): void
    {
        $movie = Movie::factory()->trashed()->createOne(['title' => 'Movie title']);
        $user = User::factory()->createOne();

        $this->actingAs($user);

        $this->get(route('movies.show', ['movie' => $movie]))
            ->assertOk();
    }

    #[DataProvider('getAllowedUsersProvider')]
    #[Test]
    public function allowed_users_can_access_a_movie(bool $isAuthenticated): void
    {
        $movie = Movie::factory()->createOne(['title' => 'Movie title']);

        if ($isAuthenticated) {
            $user = User::factory()->createOne();
            $this->actingAs($user);
        }

        $this->get(route('movies.show', ['movie' => $movie]))
            ->assertOk()
            ->assertSee('title', $movie->title);
    }

    #[Test]
    public function component_renders_correctly(): void
    {
        $movie = Movie::factory()->create();
        $user = User::factory()->createOne();

        $this->actingAs($user);

        Livewire::test(ShowMovie::class, ['movie' => $movie])
            ->assertOk()
            ->assertSeeText($movie->title)
            ->assertSeeText($movie->overview)
            ->assertSeeText($movie->release_date->format('d/m/Y'))
            ->assertSeeText($movie->poster_path);
    }

    public static function getAllowedUsersProvider(): array
    {
        return [
            'guest' => [false],
            'authenticated user' => [true],
        ];
    }
}
