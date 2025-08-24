<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\ValueObject\EntityType;
use Illuminate\Support\Facades\Storage;
use App\Services\Repositories\FileRepository;
use Intervention\Image\Laravel\Facades\Image;
use App\Models\ValueObject\FileToEntityLinkType;
use App\Services\UseCases\Commands\Tyres\Images\Handlers\StoreCommand;
use App\Services\UseCases\Commands\Tyres\Images\Handlers\StoreHandler;

class StoreHandlerTest extends TestCase
{
    protected StoreHandler $handler;
    protected FileRepository $repository;

    public function setUp(): void
    {
        parent::setUp();

        $this->handler = new StoreHandler();
        $this->repository = new FileRepository();
    }

    public function tearDown(): void
    {
        $this->repository->dropByEntity(EntityType::TYRE, 0, FileToEntityLinkType::MARKETPLACE_PHOTO);

        parent::tearDown();
    }

    public function test_store_handler_success(): void
    {
        $image = Image::create(1, 1);

        $storeCommand = new StoreCommand(
            disk: 'local',
            image: $image,
            entityId: 0,
            entityType: EntityType::TYRE,
            path: 'tests',
            baseName: 'store-handler-test',
            sort: 1
        );

        $response = $this->handler->handle($storeCommand);

        Storage::disk('local')->assertExists($response->localPath);

        $this->assertDatabaseHas('files', ['id' => $response->fileId]);
        $this->assertDatabaseHas('file_to_entity', ['file_id' => $response->fileId]);
    }
}
