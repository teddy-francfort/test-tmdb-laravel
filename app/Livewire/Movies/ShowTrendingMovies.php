<?php

namespace App\Livewire\Movies;

use App\Models\Movie;
use Illuminate\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
class ShowTrendingMovies extends Component
{
    use WithPagination;

    public string $timeWindow = 'day';

    public int $perPage = 10;

    public function mount(string $timeWindow): void
    {
        if (! in_array($timeWindow, ['day', 'week'])) {
            abort(404);
        }
    }

    public function render(): View
    {
        $perPage = ($this->perPage < 10) ? 10 : $this->perPage;

        $moviesRequest = Movie::query();

        match ($this->timeWindow) {
            'day' => $moviesRequest->trendingDay(),
            'week' => $moviesRequest->trendingWeek(),
            default => null,
        };

        $movies = $moviesRequest->orderByDesc('id')
            ->paginate($perPage);

        $pageTitle = "Trending movies for the {$this->timeWindow}";
        return view('livewire.movies.show-movies', ['movies' => $movies])
            ->title($pageTitle)
            ->with(['title' => $pageTitle]);
    }
}
