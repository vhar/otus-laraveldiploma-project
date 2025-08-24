<?php

namespace App\Models\Catalog\Tyres;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property integer $id
 * @property integer $model_id
 * @property array $rating
 */
class TyreModelRating extends Model
{
    use HasFactory;

    protected $table = 'tyre_model_ratings';

    protected $keyType = 'integer';

    public $timestamps = false;

    protected $casts = [
        'rating' => 'array'
    ];

    protected $fillable = ['model_id', 'rating'];

    public function getModelRatingAttribute(): float
    {
        $sum = array_sum(array_values($this->rating));
        $float = $sum / count($this->rating);
        return round($float * 0.1, 1);
    }
}
