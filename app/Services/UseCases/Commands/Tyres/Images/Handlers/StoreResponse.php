<?php

namespace App\Services\UseCases\Commands\Tyres\Images\Handlers;

final readonly class StoreResponse
{
    public function __construct(
        public int $fileId,
        public string $fileName,
        public string $storage,
        public string $localPath,
        public string $absolutePath,
    ) {}
}
