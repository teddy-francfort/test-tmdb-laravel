<?php

namespace Tests\Feature\Movies;

use App\Livewire\Movies\ShowMovie;
use App\Models\Movie;
use App\Models\User;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DeleteMovieTest extends TestCase
{
    #[Test]
    public function guest_cannot_deleted_movies(): void
    {
        $movie = Movie::factory()->createOne();

        $this->assertFalse($movie->trashed());
        Livewire::test(ShowMovie::class, ['movie' => $movie])
            ->call('delete')
            ->assertForbidden();

        $movie->refresh();
        $this->assertFalse($movie->trashed());
    }

    #[Test]
    public function authenticated_user_can_deleted_movies(): void
    {
        $movie = Movie::factory()->createOne();
        $user = User::factory()->createOne();
        $this->assertFalse($movie->trashed());

        $this->actingAs($user);
        Livewire::test(ShowMovie::class, ['movie' => $movie])
            ->call('delete')
            ->assertOk();

        $movie->refresh();
        $this->assertTrue($movie->trashed());
    }

    #[Test]
    public function already_deleted_movie_cannot_be_deleted(): void
    {
        $movie = Movie::factory()->trashed()->createOne();
        $user = User::factory()->createOne();
        $this->assertTrue($movie->trashed());

        $this->actingAs($user);
        Livewire::test(ShowMovie::class, ['movie' => $movie])
            ->call('delete')
            ->assertForbidden();

        $movie->refresh();
        $this->assertTrue($movie->trashed());
    }
}
