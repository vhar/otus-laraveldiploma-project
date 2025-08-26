<?php

namespace App\Listeners;

use Exception;
use App\Services\Telegram\Send;
use Illuminate\Support\Facades\Log;
use App\Events\TyreImagesJobFinihedEvent;
use App\Services\Telegram\TelegramService;
use Illuminate\Contracts\Queue\ShouldQueue;


class TyreImagesJobFinihedTelegramNotify implements ShouldQueue
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
    public function handle(TyreImagesJobFinihedEvent $event): void
    {
        try {
            $this->service->send(
                new Send(
                    recipient: env('TELEGRAM_CHAT_ID'),
                    message: 'Задание ' . $event->batchId . ' по созданию картинок завершено'
                ),
            );
        } catch (Exception $exception) {
            Log::error('Ошибка отправки сообщения в телеграм о завершении задачи ' . $event->batchId . ' по созданию картинок');
        }
    }
}
