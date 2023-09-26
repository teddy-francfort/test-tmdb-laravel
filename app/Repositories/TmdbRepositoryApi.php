<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Repositories\Datas\MovieData;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Spatie\LaravelData\CursorPaginatedDataCollection;
use Spatie\LaravelData\DataCollection;
use Spatie\LaravelData\PaginatedDataCollection;

class TmdbRepositoryApi implements TmdbRepository
{
    protected PendingRequest $client;

    public function __construct(PendingRequest $client = null)
    {
        /** @var string $baseUrl */
        $baseUrl = config('tmdb.base_url', '');
        /** @var string $token */
        $token = config('tmdb.token', '');

        $this->client = $client ?? Http::asJson()
            ->retry(3, 1000)
            ->baseUrl($baseUrl)
            ->withToken($token);
    }

    public function getTrendingMovies(string $timeWindow = 'day'): DataCollection|CursorPaginatedDataCollection|PaginatedDataCollection
    {
        $response = $this->client->get("/trending/movie/{$timeWindow}");

        /** @var array<mixed> $items */
        $items = $response->json('results');

        return MovieData::collection($items);
    }

    public function getMovieDetails(int $id): MovieData
    {
        $response = $this->client->get("/movie/{$id}");

        return MovieData::from($response->json());
    }
}
