<?php

namespace App\Services\UseCases\Commands\Tyres\Images\Handlers;

use UnexpectedValueException;
use App\Services\Interfaces\Theme\Slide;
use App\Services\Interfaces\HandlerInterface;
use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\Typography\FontFactory;
use Intervention\Image\Interfaces\ImageInterface;
use App\Services\Repositories\Common\PreparedTyre;
use App\Custom\Intervention\Image\Modifiers\RoundCornerModifier;

class FirstHandler implements HandlerInterface
{
    public function handle(Slide $slide, PreparedTyre $tyre): ImageInterface
    {
        $image = Image::read($slide->background);

        if (empty($tyre->images)) {
            throw new UnexpectedValueException('Нет картинок с прозрачным фоном для модели');
        } else {
            $tyreImage = Image::read(\file_get_contents_ssl($tyre->images[0]));
            $tyreImage->scale(height: 981);
            $image->place($tyreImage, 'top-left', 372, 252);
        }

        $brandImage = Image::read(\file_get_contents_ssl($tyre->brandLogo));
        $brandImage->scale(width: 292);
        $brandImage->modify(new RoundCornerModifier(6));
        $image->place($brandImage, 'top-left', 72, 70);

        $seasonIcon = match ($tyre->season) {
            'летние' => $slide->season->summer,
            'зимние' => $slide->season->winter,
            default => null,
        };

        if ($seasonIcon) {
            $seasonImage = Image::read($seasonIcon);

            $image->place($seasonImage, 'bottom-left', 60, 142);
        }

        if (!empty($tyre->originCountry)) {
            $countryFlag = sprintf("%s/%s.png", $slide->countryFlagPath, $tyre->originCountry);

            $countryImage = Image::read($countryFlag);
            $image->place($countryImage, 'bottom-left', 204, 143);
        }

        $image->text($tyre->modelName, 72, 239, function (FontFactory $font) use ($slide) {
            $font->filename($slide->fonts->medium);
            $font->size(64);
            $font->color($slide->color);
            $font->lineHeight(1.52);
            $font->valign('top');
            $font->wrap(756);
        });

        $image->text(sprintf("Шины %s", $tyre->season), 60, 470, function (FontFactory $font) use ($slide) {
            $font->filename($slide->fonts->regular);
            $font->size(112);
            $font->color($slide->color);
            $font->lineHeight(1.24);
            $font->valign('top');
            $font->wrap(400);
        });

        $image->text($tyre->size, 60, 720, function (FontFactory $font)  use ($slide) {
            $font->filename($slide->fonts->medium);
            $font->size(64);
            $font->color($slide->color);
            $font->lineHeight(1.44);
            $font->valign('top');
        });

        return $image;
    }
}
