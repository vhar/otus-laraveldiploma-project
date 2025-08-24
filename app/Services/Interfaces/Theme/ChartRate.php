<?php

namespace App\Services\Interfaces\Theme;

final readonly class ChartRate
{
    /**
     * Путь или ссылка на изображение полоски рейтинга
     * @param string $rate
     */
    public function __construct(
        public string $rate,
    ) {
        //
    }
}
