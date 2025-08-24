<?php

namespace App\Services\UseCases\Commands\Tyres\Images\Handlers;

use Illuminate\Support\Facades\Storage;
use App\Services\Repositories\Common\FileDTO;
use App\Services\Repositories\FileRepository;
use App\Models\ValueObject\FileToEntityLinkType;
use App\Services\Repositories\Common\LinkFileDTO;


class StoreHandler
{
    /**
     * Сохранение картинки на диск
     * @param StoreCommand $command
     * @return FileDTO
     */
    public function handle(StoreCommand $command): FileDTO
    {
        $storage = Storage::disk($command->disk);

        $fName = $command->baseName . '-' . $command->sort;

        $image = $command->image->toPng();

        $fileName = $fName . '.png';

        if ($storage->exists($command->path . '/' . $fileName)) {
            $counter = 0;
            do {
                $fileName = $fName . '_' . $counter++ . '.png';
            } while ($storage->exists($command->path . '/' . $fileName));
        }

        $filePath = $command->path . '/' . $fileName;

        $storage->put($filePath, $image);

        $repository = new FileRepository();

        $fileId = $repository->store(new FileDTO(
            storage: $command->disk,
            fileName: $fileName,
            localPath: $filePath,
            absolutePath: $storage->url($filePath),
        ));

        $repository->linkFile(
            new LinkFileDTO(
                fileId: $fileId,
                entityId: $command->entityId,
                entityType: $command->entityType->value,
                linkType: FileToEntityLinkType::MARKETPLACE_PHOTO,
                sort: $command->sort
            )
        );

        return $repository->getById($fileId);
    }
}
