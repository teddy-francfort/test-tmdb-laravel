<?php

namespace App\Console\Commands;

use App\Models\Movie;
use App\Repositories\Datas\MovieData;
use App\Repositories\TmdbRepository;
use Illuminate\Console\Command;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;

class ImportTrendingMoviesFromTMDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tmdb:import-trending-movies';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import trending movies from TMDB';

    protected TmdbRepository $tmdbRepository;

    /**
     * Execute the console command.
     */
    public function handle(TmdbRepository $repository): int
    {
        $this->info('Import trending movies from TMDB');
        $this->tmdbRepository = $repository;

        $this->updateConfiguration();
        $this->updateTrendingMovies('day');
        $this->updateTrendingMovies('week');

        return static::SUCCESS;
    }

    protected function updateTrendingMovies(string $timeWindow = 'day'): void
    {
        $this->line("Start update trending movies for time window {$timeWindow}");
        $movies = $this->tmdbRepository->getTrendingMovies($timeWindow);

        /** @var MovieData $movie */
        foreach ($movies as $movie) {
            $this->comment("Importing movie : ({$movie->tmdb_id}) {$movie->title}");
            Movie::query()->withoutGlobalScopes()->updateOrCreate(
                ['tmdb_id' => $movie->tmdb_id],
                [
                    ...$movie->toArray(),
                    "is_trending_{$timeWindow}" => true,
                ]
            );
        }

        $trendingMoviesTmdbId = Arr::pluck($movies->toArray(), 'tmdb_id');
        Movie::query()->whereNotIn('tmdb_id', $trendingMoviesTmdbId)
            ->update(["is_trending_{$timeWindow}" => false]);

        $this->line("Finish update trending movies for time window {$timeWindow}");
    }

    public function updateConfiguration(): void
    {
        $this->line('Cache configuration from tmdb');
        Cache::rememberForever('tmdb_configuration', fn () => $this->tmdbRepository->getConfiguration());
    }
}
