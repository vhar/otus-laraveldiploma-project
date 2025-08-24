<?php

namespace App\Services\Interfaces\Theme;

final readonly class Chart
{
    /**
     * Данные для слайдов с рейтингом
     * @param string $color Цвет шрифта
     * @param ChartRate[] $rates
     */
    public function __construct(
        public string $color,
        public array $rates,
    ) {
        //
    }
}
