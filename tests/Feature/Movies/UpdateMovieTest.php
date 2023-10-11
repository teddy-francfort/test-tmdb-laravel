<?php

namespace Tests\Feature\Movies;

use App\Livewire\Movies\UpdateMovie;
use App\Models\Movie;
use App\Models\User;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class UpdateMovieTest extends TestCase
{
    /** @test */
    public function guest_cannot_cannot_access_the_page(): void
    {
        $movie = Movie::factory()->createOne(['title' => 'Movie title']);

        $this->get(route('movies.edit', ['movie' => $movie]))
            ->assertRedirect();
    }

    /** @test */
    public function authenticated_user_can_access_edit_page_for_trashed_movie(): void
    {
        $movie = Movie::factory()->trashed()->createOne(['title' => 'Movie title']);
        $user = User::factory()->createOne();

        $this->actingAs($user);

        $this->get(route('movies.edit', ['movie' => $movie]))
            ->assertOk();
    }

    /** @test */
    public function authenticated_user_can_update(): void
    {
        $movie = Movie::factory()->createOne(['title' => 'Movie title']);
        $user = User::factory()->createOne();

        $this->actingAs($user);

        Livewire::test(UpdateMovie::class, ['movie' => $movie])
            ->assertOk();
    }

    /**
     * @test
     *
     * @dataProvider getGoodData
     */
    public function it_can_update_a_movie(string $field, string|bool $updatedValue): void
    {
        $movie = Movie::factory()->createOne([
            'title' => 'Movie title',
            'overview' => 'movie overview',
        ]);
        $user = User::factory()->createOne();

        $this->actingAs($user);

        Livewire::test(UpdateMovie::class, ['movie' => $movie])
            ->set('form.'.$field, $updatedValue)
            ->call('save')
            ->assertHasNoErrors()
            ->assertSessionHas('flash.banner', 'Movie updated !');

        $movie->refresh();

        $this->assertEquals($updatedValue, $movie->$field);
    }

    /**
     * @test
     *
     * @dataProvider getBadData
     */
    public function it_cannot_updated_if_not_validate(string $field, string $updatedValue): void
    {
        $movie = Movie::factory()->createOne([
            'title' => 'Movie title',
            'overview' => 'movie overview',
        ]);
        $user = User::factory()->createOne();

        $this->actingAs($user);

        Livewire::test(UpdateMovie::class, ['movie' => $movie])
            ->set('form.'.$field, $updatedValue)
            ->call('save')
            ->assertHasErrors(['form.'.$field]);

        $movie->refresh();

        $this->assertNotEquals($updatedValue, $movie->$field);
    }

    /** @test */
    public function trashed_movie_can_be_updated(): void
    {
        $movie = Movie::factory()->trashed()->createOne([
            'title' => 'Movie title',
            'overview' => 'movie overview',
        ]);
        $user = User::factory()->createOne();

        $this->actingAs($user);

        Livewire::test(UpdateMovie::class, ['movie' => $movie])
            ->set('form.title', 'Movie updated')
            ->call('save')
            ->assertHasNoErrors()
            ->assertSessionHas('flash.banner', 'Movie updated !');

        $movie->refresh();

        $this->assertEquals('Movie updated', $movie->title);
    }

    public static function getGoodData(): array
    {
        return [
            'title' => ['title', 'Movie updated'],
            'overview' => ['overview', 'overview updated'],
            'overview (nullable)' => ['overview', ''],
            'poster_path' => ['overview', '/poster_updated.jpg'],
            'poster_path (nullable)' => ['overview', ''],
            'is_trending_day (enabled)' => ['is_trending_day', true],
            'is_trending_day (disabled)' => ['is_trending_day', false],
            'is_trending_week (enabled)' => ['is_trending_week', true],
            'is_trending_week (disabled)' => ['is_trending_week', false],
        ];
    }

    public static function getBadData(): array
    {
        return [
            'title (min)' => ['title', 'mo'],
            'title (required)' => ['title', ''],
        ];
    }
}
