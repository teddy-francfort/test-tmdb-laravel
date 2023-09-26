<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property string $title
 * @property string $overview
 * @property Carbon $release_date
 * @property string $poster_path
 * @property bool $is_trending_day
 * @property bool $is_trending_week
 * @property array $data
 */
class Movie extends Model
{
    use HasFactory;

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
}
