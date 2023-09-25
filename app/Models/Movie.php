<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property string $title
 * @property string $overview
 * @property Carbon $release_date
 * @property string $poster_path
 * @property array $data
 */
class Movie extends Model
{
    use HasFactory;

    protected $casts = [
        'release_date' => 'date:Y-m-d',
        'data' => 'array',
    ];

    protected $guarded = ['id'];
}
