<?php

namespace App\Services\UseCases\Commands\Tyres\Images\Handlers;

use App\Models\ValueObject\EntityType;
use App\Services\Repositories\FileRepository;
use App\Models\ValueObject\FileToEntityLinkType;


class DeleteHandler
{
    /**
     * Удаление картиок
     * @param integer $tyreId
     * @return boolean
     */
    public function handle(int $tyreId): void
    {
        $repository = new FileRepository();

        $repository->dropByEntity(EntityType::TYRE, $tyreId, FileToEntityLinkType::MARKETPLACE_PHOTO);
    }
}
