<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Repositories\Datas\ConfigurationData;
use App\Repositories\Datas\MovieData;
use Spatie\LaravelData\CursorPaginatedDataCollection;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\PaginatedDataCollection;

interface TmdbRepository
{
    public function getMovieDetails(int $id): MovieData;

    public function getTrendingMovies(string $timeWindow = 'day'): DataCollection|CursorPaginatedDataCollection|PaginatedDataCollection;

    public function getConfiguration(): ConfigurationData;
}
