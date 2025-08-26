<?php

namespace App\Jobs;

use Exception;
use Illuminate\Bus\Batchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\UseCases\Commands\Marketplaces\Ozon\UploadTyreImageHandler;
use App\Services\UseCases\Commands\Marketplaces\Ozon\OzonPictureUploadException;

class UploadTyreImagesToOzonJob implements ShouldQueue
{
    use Queueable, Batchable;

    /**
     * Создать новый экземпляр задания.
     */
    public function __construct(
        public int $tyreId,
    ) {
        //
    }

    /**
     * Выполнить задание.
     */
    public function handle(UploadTyreImageHandler $handler): void
    {
        if ($this->batch()->cancelled()) {
            return;
        }

        try {
            $handler->handle($this->tyreId);
        } catch (OzonPictureUploadException $exception) {
            Log::error($exception->getMessage(), $exception->getDetails());
        } catch (Exception $exception) {
            Log::error($exception->getMessage());
        }
    }
}
