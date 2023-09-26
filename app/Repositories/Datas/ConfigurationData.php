<?php

declare(strict_types=1);

namespace App\Repositories\Datas;

use Spatie\LaravelData\Data;

class ConfigurationData extends Data
{
    /**
     * @param  array<string>  $poster_sizes
     */
    public function __construct(
        public string $base_url,
        public string $secure_base_url,
        public array $poster_sizes,
    ) {
    }
}
