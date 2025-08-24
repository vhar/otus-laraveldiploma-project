<?php

namespace App\Services\Interfaces\Theme;

final readonly class Season
{
    public function __construct(
        public string $winter,
        public string $summer,
    ) {
        //
    }
}
