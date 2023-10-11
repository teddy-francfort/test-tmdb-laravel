<?php

namespace Tests\Feature\Movies;

use App\Livewire\Movies\ShowMovie;
use App\Models\Movie;
use App\Models\User;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class RestoreMovieTest extends TestCase
{
    #[Test]
    public function authenticated_user_can_restore_movies(): void
    {
        $movie = Movie::factory()->trashed()->createOne();
        $user = User::factory()->createOne();
        $this->assertTrue($movie->trashed());

        $this->actingAs($user);
        Livewire::test(ShowMovie::class, ['movie' => $movie])
            ->call('restore')
            ->assertOk();

        $movie->refresh();
        $this->assertFalse($movie->trashed());
    }

    #[Test]
    public function already_restored_movie_cannot_be_restored(): void
    {
        $movie = Movie::factory()->createOne();
        $user = User::factory()->createOne();
        $this->assertFalse($movie->trashed());

        $this->actingAs($user);
        Livewire::test(ShowMovie::class, ['movie' => $movie])
            ->call('restore')
            ->assertForbidden();

        $movie->refresh();
        $this->assertFalse($movie->trashed());
    }
}
