<?php

namespace App\Models\ValueObject;

/**
 * Тип привязки файла к сущности
 */
enum FileToEntityLinkType: int
{
    case PHOTO = 1;
    case TRANSPARENT_PHOTO = 4;
    case MARKETPLACE_PHOTO = 6;
}
