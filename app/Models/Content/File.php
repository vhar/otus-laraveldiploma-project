<?php

namespace App\Models\Content;

use Carbon\Carbon;
use App\Models\Content\FileToEntity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property integer $id
 * @property string $file_name
 * @property string $storage
 * @property string $local_path
 * @property string $absolute_path
 * @property bool $is_active
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property FileToEntity[] $fileToEntities
 */
class File extends Model
{
    use HasFactory;

    protected $table = 'files';

    protected $keyType = 'integer';

    protected $fillable = ['file_name', 'storage', 'local_path', 'absolute_path', 'is_active'];

    public function fileToEntities(): HasMany
    {
        return $this->hasMany(FileToEntity::class);
    }
}
