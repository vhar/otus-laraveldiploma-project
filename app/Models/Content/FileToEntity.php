<?php

namespace App\Models\Content;

use Carbon\Carbon;
use App\Models\Content\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property integer $id
 * @property integer $file_id
 * @property string $entity_type
 * @property integer $entity_id
 * @property integer $sort
 * @property int|null $link_type
 * @property File $file
 * @property string $absolute_path
 */
class FileToEntity extends Model
{
    use HasFactory;

    protected $table = 'file_to_entity';

    protected $keyType = 'integer';

    public $timestamps = false;

    protected $fillable = ['file_id', 'entity_type', 'entity_id', 'sort', 'link_type'];

    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class);
    }

    public function getAbsolutePathAttribute(): string
    {
        return $this->file->absolute_path;
    }

    public function getCreatedAtAttribute(): Carbon
    {
        return $this->file->created_at;
    }

    /**
     * Получение массивва моделей Files для сущности
     *
     * @param string $entity_type - тип сущности
     * @param int $entity_id - ид сущности
     * @param bool $active_only - отдавать только активные
     * @param array $link_type - тип связи
     * @return File[]
     */
    public static function byEntity(string $entity_type, int $entity_id, array $link_type = []): array
    {
        if (count($link_type)) {
            $links = self::query()
                ->where('entity_type', $entity_type)
                ->where('entity_id', $entity_id)
                ->whereIn('link_type', $link_type)
                ->orderBy('sort')
                ->get();
        } else {
            $links = self::query()
                ->where('entity_type', $entity_type)
                ->where('entity_id', $entity_id)
                ->orderBy('sort')
                ->get();
        }
        $files = [];
        /** @var FileToEntity $link */
        foreach ($links as $link) {

            /** @var File $fileDb */
            $fileDb = File::query()->where('id', $link->file_id)->first();

            $files[] = $fileDb;
        }

        return $files;
    }
}
