<?php

declare(strict_types=1);

namespace App\Repositories\Datas;

use Spatie\LaravelData\Attributes\MapInputName;
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
    ) {
    }
}
