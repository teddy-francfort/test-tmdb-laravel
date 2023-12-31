<?php

namespace App\Providers;

use App\Models\Movie;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Relation::enforceMorphMap([
            'user' => User::class,
            'movie' => Movie::class,
        ]);

        $shouldBeStrict = ! $this->app->isProduction();
        Model::preventLazyLoading($shouldBeStrict);
        Model::preventSilentlyDiscardingAttributes($shouldBeStrict);
    }
}
