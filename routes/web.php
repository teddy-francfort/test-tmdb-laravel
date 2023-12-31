<?php

use App\Livewire\Movies\ShowMovie;
use App\Livewire\Movies\ShowMovies;
use App\Livewire\Movies\ShowTrendingMovies;
use App\Livewire\Movies\UpdateMovie;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
})->name('homepage');

Route::get('movies/{movie}', ShowMovie::class)
    ->withTrashed()
    ->name('movies.show');
Route::get('trending/movies/{timeWindow}', ShowTrendingMovies::class)->name('trending.movies.index');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    //Movies admin routes
    Route::get('movies', ShowMovies::class)->name('movies.index');
    Route::get('movies/{movie}/edit', UpdateMovie::class)->withTrashed()->name('movies.edit');
});
