<?php

namespace App\Models;

use App\Repositories\Datas\ConfigurationData;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;

/**
 * @property int $id
 * @property int $tmdb_id
 * @property ?string $imdb_id
 * @property string $title
 * @property ?string $overview
 * @property ?Carbon $release_date
 * @property ?string $poster_path
 * @property bool $is_trending_day
 * @property bool $is_trending_week
 * @property ?array $data
 */
class Movie extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $casts = [
        'release_date' => 'date:Y-m-d',
        'is_trending_day' => 'boolean',
        'is_trending_week' => 'boolean',
        'data' => 'array',
    ];

    protected $guarded = ['id'];

    /**
     * @param  Builder<Movie>  $query
     */
    public function scopeTrendingDay(Builder $query): void
    {
        $query->where('is_trending_day', true);
    }

    /**
     * @param  Builder<Movie>  $query
     */
    public function scopeTrendingWeek(Builder $query): void
    {
        $query->where('is_trending_week', true);
    }

    public function posterUrl(): Attribute
    {
        return Attribute::make(
            get: function () {
                /** @var ?ConfigurationData $tmdbConfiguration */
                $tmdbConfiguration = Cache::get('tmdb_configuration');

                if (is_null($tmdbConfiguration)) {
                    return $this->poster_path;
                }

                $posterSize = Arr::last($tmdbConfiguration->poster_sizes, function (string $value, int $key) {
                    return str_starts_with($value, 'w');
                });

                return $tmdbConfiguration->secure_base_url.$posterSize.$this->poster_path;
            }
        );
    }
}
