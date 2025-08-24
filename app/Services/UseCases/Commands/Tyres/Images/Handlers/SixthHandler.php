<?php

namespace App\Services\UseCases\Commands\Tyres\Images\Handlers;

use UnexpectedValueException;
use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\Typography\FontFactory;
use Intervention\Image\Interfaces\ImageInterface;
use App\Services\Repositories\Common\PreparedTyre;
use App\Services\Interfaces\Theme\Slide;
use App\Services\Interfaces\HandlerInterface;

class SixthHandler implements HandlerInterface
{
    public function handle(Slide $slide, PreparedTyre $tyre): ImageInterface
    {
        if (empty($tyre->rating)) {
            throw new UnexpectedValueException("Отсутствует рейтинг для модели шины");
        }

        $image = Image::read($slide->background);

        if (empty($tyre->images)) {
            throw new UnexpectedValueException('Нет картинки с прозрачным фоном для шестого слайда');
        } else {
            $tyreImage = Image::read(\file_get_contents_ssl($tyre->images[0]));

            $tyreImage->scale(height: 1610);
            $image->place($tyreImage, 'top-center', 0, 539);
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

        $params = [
            'Сухая дорога' => true,
            'Мокрая дорога' => true,
            'Комфорт' => true,
            'Устойчивость' => true,
            'Бесшумность' => true,
            'Торможение' => true,
            'Аквапланирование' => true,
            'Скорость' => true,
            'Износоустойчивость' => true,
            'Качество' => true,
            'Цена/качество' => true,
        ];

        $data = array_intersect_key($tyre->rating, $params);

        $values = array_values($data);

        $rate = round(array_sum($values) * 0.1 / count($values), 1);

        $image->text($rate, 450, 590, function (FontFactory $font)  use ($slide) {
            $font->filename($slide->fonts->bold);
            $font->size(180);
            $font->color($slide->color);
            $font->align('center');
            $font->valign('middle');
        });

        return $image;
    }
}
