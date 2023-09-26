<?php

namespace App\Livewire\Forms;

use App\Models\Movie;
use Livewire\Attributes\Rule;
use Livewire\Form;

class UpdateMovieForm extends Form
{
    #[Rule('required|min:3', as: 'title')]
    public string $title = '';

    #[Rule('nullable', as: 'overview')]
    public ?string $overview = '';

    #[Rule('nullable', as: 'poster path')]
    public ?string $poster_path = '';

    #[Rule('boolean', as: 'is trending day')]
    public bool $is_trending_day = false;

    #[Rule('boolean', as: 'is trending week')]
    public bool $is_trending_week = false;

    public function setMovie(Movie $movie): void
    {
        $this->title = $movie->title;
        $this->overview = $movie->overview;
        $this->poster_path = $movie->poster_path;
        $this->is_trending_day = $movie->is_trending_day;
        $this->is_trending_week = $movie->is_trending_week;
    }
}
