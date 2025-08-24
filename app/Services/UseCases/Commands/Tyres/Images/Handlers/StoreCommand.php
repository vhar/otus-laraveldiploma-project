<?php

namespace App\Services\UseCases\Commands\Tyres\Images\Handlers;

use App\Models\ValueObject\EntityType;
use Intervention\Image\Interfaces\ImageInterface as Image;

final readonly class StoreCommand
{
    public function __construct(
        public string $disk,
        public Image $image,
        public EntityType $entityType,
        public int $entityId,
        public string $path,
        public string $baseName,
        public int $sort,
    ) {}
}
