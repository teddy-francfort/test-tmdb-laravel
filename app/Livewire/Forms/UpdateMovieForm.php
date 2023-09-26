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
    public string $overview = '';

    #[Rule('nullable', as: 'poster path')]
    public string $poster_path = '';

    public function setMovie(Movie $movie): void
    {
        $this->title = $movie->title;
        $this->overview = $movie->overview;
        $this->poster_path = $movie->poster_path;
    }
}
