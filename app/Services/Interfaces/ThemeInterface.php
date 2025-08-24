<?php

namespace App\Services\Interfaces;

use App\Services\Interfaces\Theme\Theme;

interface ThemeInterface
{
    public function get(): Theme;
}
