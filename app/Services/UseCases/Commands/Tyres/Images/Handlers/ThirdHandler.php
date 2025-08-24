<?php

namespace App\Services\UseCases\Commands\Tyres\Images\Handlers;

use UnexpectedValueException;
use App\Services\Interfaces\Theme\Slide;
use App\Services\Interfaces\HandlerInterface;
use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\Typography\FontFactory;
use Intervention\Image\Interfaces\ImageInterface;
use App\Services\Repositories\Common\PreparedTyre;

class ThirdHandler implements HandlerInterface
{
    public function handle(Slide $slide, PreparedTyre $tyre): ImageInterface
    {
        $image = Image::read($slide->background);

        if (empty($tyre->images[1])) {
            throw new UnexpectedValueException('Нет картинки с прозрачным фоном для третьего слайда');
        } else {
            $tyreImage = Image::read(\file_get_contents_ssl($tyre->images[1]));

            $tyreImage->scale(width: 1650);
            $image->place($tyreImage, 'top-center', 0, 465);
        }

        if (empty($tyre->tredPattern)) {
            throw new UnexpectedValueException('Не указан рисунок протектора для модели');
        } else {
            $image->text($tyre->tredPattern, 450, 500, function (FontFactory $font)  use ($slide) {
                $font->filename($slide->fonts->bold);
                $font->size(60);
                $font->color($slide->color);
                $font->align('center');
                $font->valign('top');
                $font->lineHeight(1.44);
                $font->wrap(780);
            });
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

        return $image;
    }
}
