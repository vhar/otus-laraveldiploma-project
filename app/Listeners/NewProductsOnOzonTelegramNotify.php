<?php

namespace App\Listeners;

use Exception;
use Illuminate\Support\Facades\Log;
use App\Events\NewProductsOnOzonEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Services\UseCases\Commands\Telegram\Marcetplases\Ozon\NewProductsCommand;
use App\Services\UseCases\Commands\Telegram\Marcetplases\Ozon\NewProductsHandler;

class NewProductsOnOzonTelegramNotify implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct(private NewProductsHandler $handler)
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NewProductsOnOzonEvent $event): void
    {
        try {
            $this->handler->handle(new NewProductsCommand(
                recipient: env('TELEGRAM_CHAT_ID'),
                productIds: $event->productIds,
                start: $event->start,
                end: $event->end
            ));
        } catch (Exception $exception) {
            Log::error("Ошибка отправки сообщения в телеграм о новых продуктах на озон. {$exception->getMessage()}");
        }
    }
}
