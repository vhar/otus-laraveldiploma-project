<?php

namespace App\Services\UseCases\Commands\Telegram\Marcetplases\Ozon;

use App\Services\Telegram\Send;
use App\Services\Telegram\SendResult;
use App\Services\Telegram\TelegramService;
use App\Services\Repositories\TyreRepository;

class NewProductsHandler
{
    public function __construct(
        public TyreRepository $repository,
        public TelegramService $service

    ) {}

    /**
     * Summary of handle
     * @param NewProductsCommand $command
     * @return SendResult
     */
    public function handle(NewProductsCommand $command): SendResult
    {

        $message = view('notifications.telegram.new-products-on-ozon', ['command' => $command]);

        return $this->service->send(new Send(
            recipient: $command->recipient,
            message: $message->render(),
        ));
    }
}
