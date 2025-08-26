<?php

namespace App\Listeners;

use Exception;
use App\Services\Telegram\Send;
use Illuminate\Support\Facades\Log;
use App\Services\Telegram\TelegramService;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\UploadTyreImagesToOzonJobFinihedEvent;


class UploadTyreImagesToOzonJobFinihedTelegramNotify implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct(private TelegramService $service)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UploadTyreImagesToOzonJobFinihedEvent $event): void
    {
        try {
            $this->service->send(
                new Send(
                    recipient: env('TELEGRAM_CHAT_ID'),
                    message: 'Задание ' . $event->batchId . ' по выгрузке картинок на Озон завершено'
                ),
            );
        } catch (Exception $exception) {
            Log::error('Ошибка отправки сообщения в телеграм о завершении задачи ' . $event->batchId . ' по выгрузке картинок на Озон');
        }
    }
}
