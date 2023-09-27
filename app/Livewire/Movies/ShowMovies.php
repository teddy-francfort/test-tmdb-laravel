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

    public string $search = '';

    public int $perPage = 10;

    public function searchMovies(): void
    {
        $this->resetPage();
    }

    public function render(): View
    {
        $perPage = ($this->perPage < 10) ? 10 : $this->perPage;

        $moviesRequest = Movie::query()->orderByDesc('id');

        if (! empty($this->search)) {
            $moviesRequest->where('title', 'like', "%{$this->search}%");
        }

        $movies = $moviesRequest->paginate($perPage);

        return view('livewire.movies.show-movies', ['movies' => $movies]);
    }
}
