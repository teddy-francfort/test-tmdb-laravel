<?php

declare(strict_types=1);

namespace App\Repositories\Datas;

use Illuminate\Support\Carbon;
use Spatie\LaravelData\Attributes\MapInputName;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;

class MovieData extends Data
{
    public function __construct(
        #[MapInputName('id')]
        public int $tmdb_id,
        public ?string $imdb_id,
        public string $title,
        public string $overview,
        public string $poster_path,
        #[WithCast(DateTimeInterfaceCast::class, format: 'Y-m-d')]
        public Carbon $release_date,
    ) {
    }
}
