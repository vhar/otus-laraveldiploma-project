<?php

namespace App\Services\UseCases\Commands\Tyres\Images\Handlers;

use UnexpectedValueException;
use App\Services\Interfaces\Theme\Slide;
use App\Services\Interfaces\HandlerInterface;
use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\Typography\FontFactory;
use Intervention\Image\Interfaces\ImageInterface;
use App\Services\Repositories\Common\PreparedTyre;


class SecondHandler implements HandlerInterface
{
    public function handle(Slide $slide, PreparedTyre $tyre): ImageInterface
    {
        $image = Image::read($slide->background);

        if (empty($tyre->images[2])) {
            throw new UnexpectedValueException('Нет картинки с прозрачным фоном для второго слайда');
        } else {
            $tyreImage = Image::read(\file_get_contents_ssl($tyre->images[2]));

            $tyreImage->scale(width: 1494);
            $image->place($tyreImage, 'top-center', 0, 234);
        }

        $image->text($tyre->brandName, 450, 200, function (FontFactory $font) use ($slide) {
            $font->filename($slide->fonts->medium);
            $font->size(54);
            $font->color($slide->color);
            $font->align('center');
            $font->valign('middle');
        });

        $image->text($tyre->modelName, 450, 241, function (FontFactory $font) use ($slide) {
            $font->filename($slide->fonts->medium);
            $font->size(54);
            $font->color($slide->color);
            $font->align('center');
            $font->valign('top');
            $font->lineHeight(1.52);
            $font->wrap(780);
        });

        $image->text($tyre->sizeWithOptions, 450, 407, function (FontFactory $font)  use ($slide) {
            $font->filename($slide->fonts->medium);
            $font->size(48);
            $font->color($slide->color);
            $font->align('center');
            $font->valign('middle');
        });

        $image->text('ИНДЕКС НАГРУЗКИ', 260, 529, function (FontFactory $font)  use ($slide) {
            $font->filename($slide->fonts->medium);
            $font->size(25);
            $font->color($slide->color);
            $font->align('right');
            $font->valign('middle');
            $font->wrap(200);
            $font->lineHeight(1.65);
        });

        $image->text($tyre->loadIndex, 300, 526, function (FontFactory $font)  use ($slide) {
            $font->filename($slide->fonts->bold);
            $font->size(72);
            $font->color($slide->color);
            $font->valign('middle');
        });

        $image->text('ИНДЕКС СКОРОСТИ', 260, 647, function (FontFactory $font)  use ($slide) {
            $font->filename($slide->fonts->medium);
            $font->size(25);
            $font->color($slide->color);
            $font->align('right');
            $font->valign('middle');
            $font->wrap(200);
            $font->lineHeight(1.65);
        });

        $image->text($tyre->speedIndex, 300, 642, function (FontFactory $font)  use ($slide) {
            $font->filename($slide->fonts->bold);
            $font->size(72);
            $font->color($slide->color);
            $font->valign('middle');
        });

        return $image;
    }
}
