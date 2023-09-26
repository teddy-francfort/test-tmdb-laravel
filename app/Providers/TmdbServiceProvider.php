<?php

namespace App\Providers;

use App\Repositories\TmdbRepository;
use App\Repositories\TmdbRepositoryApi;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class TmdbServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(TmdbRepository::class, function (Application $app) {
            return new TmdbRepositoryApi(null);
        });
    }
}
