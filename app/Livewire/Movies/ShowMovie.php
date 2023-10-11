<?php

namespace App\Livewire\Movies;

use App\Models\Movie;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class ShowMovie extends Component
{
    public Movie $movie;

    public function mount(Movie $movie): void
    {
        $this->authorize('view', $movie);
        $this->movie = $movie;
    }

    public function render(): View
    {
        return view('livewire.movies.show-movie');
    }

    public function delete(): void
    {
        $this->authorize('delete', $this->movie);
        $this->movie->delete();
    }
}
