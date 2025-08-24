<?php

namespace App\Services\UseCases\Queries\Tyres\Images;

use App\Models\ValueObject\EntityType;
use App\Services\Repositories\FileRepository;
use App\Models\ValueObject\FileToEntityLinkType;

class ImagesFetcher
{
    private FileRepository $repository;

    public function __construct()
    {
        $this->repository = new FileRepository();
    }

    public function fetch(int $tyreId): array
    {
        return array_column(
            $this->repository->getByEntity(
                EntityType::TYRE,
                $tyreId,
                FileToEntityLinkType::MARKETPLACE_PHOTO
            ),
            'absolutePath'
        );
    }
}
