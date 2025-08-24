<?php

namespace App\Services\Interfaces\Theme;

final readonly class Fonts
{
    public function __construct(
        public string $light,
        public string $regular,
        public string $medium,
        public string $bold,
    ) {
        //
    }
}
