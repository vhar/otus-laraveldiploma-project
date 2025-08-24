<?php

namespace App\Services\Repositories\Common;

final readonly class PreparedTyre
{
    public function __construct(
        public int $tyreId,
        public string $article,
        public string $name,
        public string $brandName,
        public string $brandSlug,
        public string $brandLogo,
        public string $modelName,
        public string $modelSlug,
        public string $season,
        public string $size,
        public string $sizeWithOptions,
        public string $tredPattern,
        public string $loadIndex,
        public string $speedIndex,
        public array $rating,
        public array $images,
        public string $originCountry,
        public string $slug
    ) {}
}
