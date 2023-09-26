<?php

namespace App\Livewire\Movies;

use App\Models\Movie;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class ShowMovies extends Component
{
    use WithPagination;

    public int $perPage = 10;

    public function render(): View
    {
        $perPage = ($this->perPage < 10) ? 10 : $this->perPage;

        $movies = Movie::query()->orderByDesc('id')->paginate($perPage);

        return view('livewire.movies.show-movies', ['movies' => $movies]);
    }
}
