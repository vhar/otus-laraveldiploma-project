<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\ValueObject\EntityType;
use Illuminate\Support\Facades\Storage;
use App\Services\Repositories\Common\FileDTO;
use App\Services\Repositories\FileRepository;
use Intervention\Image\Laravel\Facades\Image;
use App\Models\ValueObject\FileToEntityLinkType;
use App\Services\Repositories\Common\LinkFileDTO;
use App\Services\UseCases\Commands\Tyres\Images\Handlers\DeleteHandler;

class DeleteHandlerTest extends TestCase
{
    protected DeleteHandler $handler;
    protected FileRepository $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->handler = new DeleteHandler();
        $this->repository = new FileRepository();
    }

    public function test_delete_handler_success(): void
    {
        $storage = Storage::disk('local');

        $image = Image::create(1, 1);

        $fName = 'store-handler-test-1';
        $file = $image->toPng();

        $fileName = $fName . '.png';

        if ($storage->exists('tests/' . $fileName)) {
            $counter = 0;
            do {
                $fileName = $fName . '_' . $counter++ . '.png';
            } while ($storage->exists('tests/' . $fileName));
        }

        $filePath =  'tests/' . $fileName;

        $storage->put($filePath, $file);

        $repository = new FileRepository();

        $fileId = $repository->store(new FileDTO(
            storage: 'local',
            fileName: $fileName,
            localPath: $filePath,
            absolutePath: $storage->url($filePath),
        ));

        $repository->linkFile(
            new LinkFileDTO(
                fileId: $fileId,
                entityId: $fileId,
                entityType: EntityType::TYRE->value,
                linkType: FileToEntityLinkType::MARKETPLACE_PHOTO,
                sort: 1
            )
        );

        $this->handler->handle($fileId);

        Storage::disk('local')->assertMissing($filePath);

        $this->assertDatabaseMissing('files', ['id' => $fileId]);
        $this->assertDatabaseMissing('file_to_entity', ['file_id' => $fileId]);
    }
}
