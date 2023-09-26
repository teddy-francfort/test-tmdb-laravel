<?php

namespace App\Livewire\Movies;

use App\Livewire\Forms\UpdateMovieForm;
use App\Models\Movie;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.app')]
class UpdateMovie extends Component
{
    public Movie $movie;

    public UpdateMovieForm $form;

    public function mount(Movie $movie): void
    {
        $this->form->setMovie($movie);
    }

    public function render(): View
    {
        return view('livewire.movies.update-movie');
    }

    public function save(): void
    {
        $this->authorize('update', $this->movie);

        $this->validate();

        $this->movie->update($this->form->all());

        session()->flash('flash.banner', 'Movie updated !');
        session()->flash('flash.bannerStyle', 'success');

        $this->redirect(route('movies.edit', ['movie' => $this->movie]));
    }
}
