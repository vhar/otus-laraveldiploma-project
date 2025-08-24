<?php

namespace App\Models\Marketplaces\Ozon;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property int $tyre_id
 * @property int $ozon_product_id
 * @property ?string $sku
 * @property string $article
 * @property ?Carbon $picture_upload_at
 * @property ?Carbon $created_at
 * @property ?Carbon $udated_at
 */

class TyreOnOzon extends Model
{
    use HasFactory;

    protected $table = 'tyre_on_ozon';

    protected $fillable = ['tyre_id', 'ozon_product_id', 'picture_upload_at', 'sku', 'article'];

    protected function casts(): array
    {
        return [
            'picture_upload_at' => 'datetime',
        ];
    }
}
