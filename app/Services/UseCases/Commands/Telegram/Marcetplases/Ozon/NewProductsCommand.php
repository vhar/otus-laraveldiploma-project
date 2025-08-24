<?php

namespace App\Services\UseCases\Commands\Telegram\Marcetplases\Ozon;

use Carbon\Carbon;

final readonly class NewProductsCommand
{
    public function __construct(
        public int $recipient,
        public array $productIds,
        public Carbon $start,
        public Carbon $end
    ) {}
}
