<?php

namespace App\Services\Interfaces\Theme;

use App\Services\Interfaces\HandlerInterface;

final readonly class Slide
{
    public function __construct(
        public HandlerInterface $handler,
        public string $background,
        public string $color,
        public Fonts $fonts,
        public ?Chart $chart = null,
        public ?Season $season = null,
        public ?string $countryFlagPath = null,
    ) {
        //
    }
}
