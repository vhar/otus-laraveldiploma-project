<?php

namespace App\Jobs;

use App\Models\ValueObject\EntityType;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Foundation\Queue\Queueable;
use App\Services\Interfaces\ThemeInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\Repositories\TyreRepository;
use App\Services\UseCases\Commands\Tyres\Images\Handlers\StoreCommand;
use App\Services\UseCases\Commands\Tyres\Images\Handlers\StoreHandler;
use App\Services\UseCases\Commands\Tyres\Images\Handlers\DeleteHandler;

class HandleTyreImagesJob implements ShouldQueue
{
    use Queueable;

    /**
     * Создать новый экземпляр задания.
     */
    public function __construct(
        public ThemeInterface $theme,
        public int $tyreId
    ) {
        //
    }

    /**
     * Выполнить задание.
     */
    public function handle(TyreRepository $repository, StoreHandler $handler, DeleteHandler $delete): void
    {
        $tyre = $repository->getPreparedTyre($this->tyreId);

        $theme = $this->theme->get();

        $delete->handle($this->tyreId);

        $index = 1;

        foreach ($theme->slides as $slide) {
            try {
                $image = $slide->handler->handle($slide, $tyre);

                $storeCommand = new StoreCommand(
                    disk: config()->get('marketplaces.storage'),
                    image: $image,
                    entityId: $tyre->tyreId,
                    entityType: EntityType::TYRE,
                    path: 'marketplaces/' . $tyre->brandSlug . '/' . $tyre->modelSlug,
                    baseName: $tyre->slug,
                    sort: $index
                );

                $handler->handle($storeCommand);
            } catch (Exception $exception) {
                Log::error($exception->getMessage());
            }

            $index++;
        }

        Artisan::call('optimize:clear');
    }
}
