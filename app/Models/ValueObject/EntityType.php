<?php

namespace App\Models\ValueObject;

/** Типы сущностей, которые есть в системе */
enum EntityType: string
{
    case TYRE_BRAND = 'tyre_brands';
    case TYRE_MODEL = 'tyre_models';
    case TYRE = 'tyres';

    public static function names()
    {
        return [
            self::TYRE_BRAND->value => 'Бренд шины',
            self::TYRE_MODEL->value => 'Модель шины',
            self::TYRE->value => 'Шина',
        ];
    }
}
