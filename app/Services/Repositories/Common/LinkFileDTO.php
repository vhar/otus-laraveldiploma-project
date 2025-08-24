<?php

namespace App\Services\Repositories\Common;

use App\Models\ValueObject\FileToEntityLinkType;

final readonly class LinkFileDTO
{
    public function __construct(
        public int $fileId,
        public int $entityId,
        public string $entityType,
        public FileToEntityLinkType $linkType,
        public ?int $sort = 100
    ) {}
}
