<?php

namespace App\Services\Repositories\Common;

final readonly class FileDTO
{
    public function __construct(
        public string $storage,
        public string $fileName,
        public string $localPath,
        public string $absolutePath,
        public ?bool $isActive = true,
        public ?int $fileId = null
    ) {}
}
