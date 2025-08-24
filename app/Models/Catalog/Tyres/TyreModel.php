<?php

namespace App\Models\Catalog\Tyres;

use App\Models\Content\File;
use App\Models\Content\FileToEntity;
use App\Models\ValueObject\EntityType;
use App\Models\Catalog\Tyres\TyreBrand;
use Illuminate\Database\Eloquent\Model;
use App\Models\Catalog\Tyres\TyreModelRating;
use App\Models\ValueObject\FileToEntityLinkType;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;


/**
 * @property integer $id
 * @property integer $brand_id
 * @property string $title
 * @property string $slug
 * @property ?string $tread_pattern
 * @property TyreBrand $tyreBrand
 * @property TyreModelRating $rating
 * @property FileToEntity[] $photoEntities
 */

class TyreModel extends Model
{
    use HasFactory;

    protected $table = 'tyre_models';

    public $timestamps = false;

    protected $fillable = ['brand_id', 'title', 'slug', 'tread_pattern'];

    public function tyreBrand(): BelongsTo
    {
        return $this->belongsTo(TyreBrand::class, 'brand_id');
    }

    public function rating(): HasOne
    {
        return $this->hasOne(TyreModelRating::class, 'model_id');
    }

    public function photoEntities(): HasMany
    {
        return $this->hasMany(FileToEntity::class, 'entity_id')
            ->where('entity_type', EntityType::TYRE_MODEL)
            ->where('link_type', FileToEntityLinkType::TRANSPARENT_PHOTO)
            ->orderBy('sort');
    }

    /**
     * @return File[]
     */
    public function photos(): array
    {
        return FileToEntity::byEntity(
            EntityType::TYRE_MODEL->value,
            $this->id,
            [FileToEntityLinkType::TRANSPARENT_PHOTO]
        );
    }
}
