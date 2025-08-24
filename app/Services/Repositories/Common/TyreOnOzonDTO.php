<?php

namespace App\Services\Repositories\Common;

use Carbon\Carbon;

final readonly class TyreOnOzonDTO
{
    public function __construct(
        public int $tyreId,
        public int $ozonProductId,
        public ?string $sku = null,
        public ?Carbon $picture_upload_at = null,
    ) {}
}
