<?php

namespace App\Models\Catalog\Tyres;

use App\Models\Content\File;
use App\Models\Content\FileToEntity;
use App\Models\ValueObject\EntityType;
use Illuminate\Database\Eloquent\Model;
use App\Models\ValueObject\FileToEntityLinkType;
use Illuminate\Database\Eloquent\Factories\HasFactory;


/**
 * @property integer $id
 * @property string $title
 * @property string $slug
 * @property ?string $origin_country
 */
class TyreBrand extends Model
{
    use HasFactory;
    protected $table = 'tyre_brands';

    public $timestamps = false;

    protected $fillable = ['title', 'slug', 'origin_country'];

    /**
     * Возвращает файл логотипа бренда
     * @return File|null
     */
    public function logo(): ?File
    {
        $files = FileToEntity::byEntity(EntityType::TYRE_BRAND->value, $this->id, [FileToEntityLinkType::PHOTO]);

        if ($files) {
            return $files[0];
        }

        return null;
    }
}
