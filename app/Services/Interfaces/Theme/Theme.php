<?php

namespace App\Services\Interfaces\Theme;

final readonly class Theme
{
    /**
     * Данные темы для картинок
     * @param string $name
     * @param string $thumbnail
     * @param Slide[] $slides
     */
    public function __construct(
        public string $name,
        public string $thumbnail,
        public array $slides,
    ) {
        //
    }
}
