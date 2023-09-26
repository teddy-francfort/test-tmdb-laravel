<?php

namespace Tests\Feature\Movies;

use App\Models\Movie;
use Tests\TestCase;

class MovieControllerShowTest extends TestCase
{
    /** @test */
    public function it_renders_correctly(): void
    {
        $movie = Movie::factory()->create();

        $this->get(route('movies.show', ['movie' => $movie]))
            ->assertOk()
            ->assertSeeText($movie->title)
            ->assertSeeText($movie->overview)
            ->assertSeeText($movie->release_date->format('d/m/Y'))
            ->assertSeeText($movie->poster_path);
    }
}
