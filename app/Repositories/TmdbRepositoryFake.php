<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Repositories\Datas\MovieData;
use Illuminate\Support\Facades\Storage;
use Spatie\LaravelData\CursorPaginatedDataCollection;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\PaginatedDataCollection;

class TmdbRepositoryFake implements TmdbRepository
{
    public function getTrendingMovies(string $timeWindow = 'day'): DataCollection|CursorPaginatedDataCollection|PaginatedDataCollection
    {
        $response = Storage::disk('test')->json('Feature/Repositories/fixtures/trending_movie.json');

        $items = $response['results'] ?? [];

        return MovieData::collection($items);
    }

    public function getMovieDetails(int $id): MovieData
    {
        $response = Storage::disk('test')->json('Feature/Repositories/fixtures/movie_121.json');

        return MovieData::from($response);
    }
}
