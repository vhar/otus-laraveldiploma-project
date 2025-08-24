<?php

namespace App\Services\Interfaces;

use \Intervention\Image\Interfaces\ImageInterface;
use App\Services\Repositories\Common\PreparedTyre;
use App\Services\Interfaces\Theme\Slide;

interface HandlerInterface
{
    /**
     * Генератор картинки
     * @param Slide $slide
     * @param PreparedTyre $tyre
     * @return ImageInterface
     */
    public function handle(Slide $slide, PreparedTyre $tyre): ImageInterface;
}
