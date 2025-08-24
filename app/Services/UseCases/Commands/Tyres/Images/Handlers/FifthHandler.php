<?php

namespace App\Services\UseCases\Commands\Tyres\Images\Handlers;

use UnexpectedValueException;
use Intervention\Image\Laravel\Facades\Image;
use Intervention\Image\Typography\FontFactory;
use Intervention\Image\Interfaces\ImageInterface;
use App\Services\Repositories\Common\PreparedTyre;
use App\Services\Interfaces\Theme\Slide;
use App\Services\Interfaces\HandlerInterface;


class FifthHandler implements HandlerInterface
{
    public function handle(Slide $slide, PreparedTyre $tyre): ImageInterface
    {
        if (empty($tyre->rating)) {
            throw new UnexpectedValueException("Отсутствует рейтинг для модели шины");
        }

        $image = Image::read($slide->background);

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
            'Аквапланирование' => true,
            'Скорость' => true,
            'Износоустойчивость' => true,
            'Качество' => true,
            'Цена/качество' => true,
        ];

        $data = array_intersect_key($tyre->rating, $params);

        $offset_y = 550;
        foreach ($data as $key => $value) {
            $value = $value * 0.1;

            if ($key == 'Цена/качество') {
                $key = 'Цена';
            }

            $image->text($key, 60, ($offset_y - 38), function (FontFactory $font)  use ($slide) {
                $font->filename($slide->fonts->medium);
                $font->size(40);
                $font->color($slide->color);
                $font->align('left');
                $font->valign('middle');
            });

            $image->text(number_format($value, 1), 840, ($offset_y - 38), function (FontFactory $font)  use ($slide) {
                $font->filename($slide->fonts->bold);
                $font->size(40);
                $font->color($slide->chart->color);
                $font->align('right');
                $font->valign('middle');
            });

            $chart = $slide->chart->rates[round($value)]->rate;

            $chartImage = Image::read($chart);
            $image->place($chartImage, 'top-left', 60, $offset_y);

            $offset_y += 111;
        }

        return $image;
    }
}
