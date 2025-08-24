<?php

namespace App\Services\Repositories;

use Illuminate\Support\Arr;
use App\Models\Content\File;
use App\Models\Content\FileToEntity;
use App\Models\ValueObject\EntityType;
use Illuminate\Support\Facades\Storage;
use App\Services\Repositories\Common\FileDTO;
use App\Models\ValueObject\FileToEntityLinkType;
use App\Services\Repositories\Common\LinkFileDTO;
use App\Services\Repositories\Common\ModelNotFoundException;
use App\Services\Repositories\Common\ModelCrateFailedException;

class FileRepository
{
    /**
     * Получить модель файла по id
     * @param int $fileId
     * @throws ModelNotFoundException
     * @return FileDTO
     */
    public function getById(int $fileId)
    {
        $fileDb = File::whereId($fileId)->first();

        if (!$fileDb) {
            throw new ModelNotFoundException('Не найдена модель для файла.');
        }

        return new FileDTO(
            storage: $fileDb->storage,
            fileName: $fileDb->file_name,
            localPath: $fileDb->local_path,
            absolutePath: $fileDb->absolute_path,
            isActive: $fileDb->is_active,
            fileId: $fileDb->id,
        );
    }

    /**
     * Создать запись для файла
     * @param FileDTO $file
     * @throws ModelCrateFailedException
     * @return int
     */
    public function store(FileDTO $file): int
    {
        $fileDb = new File();
        $fileDb->file_name = $file->fileName;
        $fileDb->storage = $file->storage;
        $fileDb->local_path = $file->localPath;
        $fileDb->absolute_path = $file->absolutePath;
        $fileDb->is_active = $file->isActive;

        if ($fileDb->save()) {
            return $fileDb->id;
        } else {
            throw new ModelCrateFailedException('Не удалось создать модель для файла.');
        }
    }

    /**
     * Связывет файл с сущностью
     * @param LinkFileDTO $link
     * @throws ModelNotFoundException
     * @throws ModelCrateFailedException
     * @return int
     */
    public function linkFile(LinkFileDTO $link): int
    {
        $fileDb = File::whereId($link->fileId)->first();

        if (!$fileDb) {
            throw new ModelNotFoundException('Не найдена модель для файла.');
        }

        $linked = FileToEntity::firstOrCreate([
            'file_id' => $fileDb->id,
            'entity_id' => $link->entityId,
            'entity_type' => $link->entityType,
            'link_type' => $link->linkType
        ]);

        $linked->sort = $link->sort;

        $linked->save();

        if ($linked) {
            return $linked->id;
        } else {
            throw new ModelCrateFailedException('Не удалось связать файл с сущностью.');
        }
    }

    /**
     * Получить массив файлов определенного типа для сущности
     * @param EntityType $entityType
     * @param int $entityId
     * @param FileToEntityLinkType $linkType
     * @return FileDTO[]
     */
    public function getByEntity(EntityType $entityType, int $entityId, FileToEntityLinkType $linkType): array
    {
        $entities = FileToEntity::byEntity($entityType->value, $entityId, [$linkType]);

        $files = array_map(fn($file) => new FileDTO(
            storage: $file->file_name,
            fileName: $file->storage,
            localPath: $file->local_path,
            absolutePath: $file->absolute_path,
            fileId: $file->id
        ), Arr::from($entities));

        return $files;
    }

    /**
     * Удалить файлы определенного типа для сущности
     * @param EntityType $entityType
     * @param int $entityId
     * @param FileToEntityLinkType $linkType
     * @return void
     */
    public function dropByEntity(EntityType $entityType, int $entityId, FileToEntityLinkType $linkType): void
    {
        $entities = FileToEntity::byEntity($entityType->value, $entityId, [$linkType]);

        foreach ($entities as $entity) {
            if ($fileDb = File::find($entity->id)) {
                $filesystem = Storage::disk($fileDb->storage);

                if ($filesystem->exists($fileDb->local_path)) {
                    $filesystem->delete($fileDb->local_path);
                }

                $fileDb->fileToEntities()->delete();
                $fileDb->delete();
            }
        }
    }
}
