<?php

namespace App\Models\Catalog\Tyres;

use Orchid\Screen\AsSource;
use Illuminate\Support\Carbon;
use Orchid\Filters\Filterable;
use App\Models\Content\FileToEntity;
use App\Models\ValueObject\EntityType;
use App\Models\Catalog\Tyres\TyreBrand;
use App\Models\Catalog\Tyres\TyreModel;
use Illuminate\Database\Eloquent\Model;
use App\Models\Marketplaces\Ozon\TyreOnOzon;
use App\Models\ValueObject\FileToEntityLinkType;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property integer $id
 * @property integer $brand_id
 * @property integer $model_id
 * @property string $slug
 * @property string $article
 * @property string $title
 * @property ?double $diameter
 * @property ?double $width
 * @property ?double $height
 * @property string $season
 * @property ?string $load_index
 * @property ?string $speed_index
 * @property boolean $is_extra_load
 * @property boolean $is_run_flat
 * @property boolean $is_stud
 * @property boolean $is_active
 * @property TyreBrand $tyreBrand
 * @property TyreModel $tyreModel
 * @property array $missing_data
 */

class Tyre extends Model
{
    use HasFactory;

    use AsSource, Filterable;

    protected $table = 'tyres';

    public $timestamps = false;

    protected $fillable = [
        'model_id',
        'slug',
        'article',
        'title',
        'diameter',
        'width',
        'height',
        'season',
        'load_index',
        'speed_index',
        'is_extra_load',
        'is_run_flat',
        'is_stud',
        'is_active'
    ];

    public function getTyreBrandAttribute(): TyreBrand
    {
        return $this->tyreModel->tyreBrand;
    }

    public function tyreModel(): BelongsTo
    {
        return $this->belongsTo(TyreModel::class, 'model_id');
    }

    public function onOzon(): HasOne
    {
        return $this->hasOne(TyreOnOzon::class, 'tyre_id');
    }

    public function modelPhotoEntities(): HasMany
    {
        return $this->hasMany(FileToEntity::class, 'entity_id', 'model_id')
            ->where('entity_type', EntityType::TYRE_MODEL)
            ->where('link_type', FileToEntityLinkType::TRANSPARENT_PHOTO)
            ->orderBy('sort');
    }

    public function marketplacePhotoEntities(): HasMany
    {
        return $this->hasMany(FileToEntity::class, 'entity_id')
            ->where('entity_type', EntityType::TYRE)
            ->where('link_type', FileToEntityLinkType::MARKETPLACE_PHOTO)
            ->orderBy('sort');
    }

    public function getMissingDataAttribute(): array
    {
        $images = $this->tyreModel->photoEntities;
        $missing = [];

        if (!count($images)) {
            $missing[] = 'Нет картинок с прозрачным фоном для модели';
        } else {
            if (empty($images[2])) {
                $missing[] = 'Нет картинки с прозрачным фоном для второго слайда';
            }
            if (empty($images[1])) {
                $missing[] = 'Нет картинки с прозрачным фоном для третьего слайда';
            }
        }

        if (!$this->tyreModel->tread_pattern) {
            $missing[] = 'Не указан рисунок протектора для модели';
        }

        if (empty($this->tyreModel->rating)) {
            $missing[] = "Отсутствует рейтинг для модели шины";
        }

        return $missing;
    }
}
