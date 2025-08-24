<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * @property integer $id
 * @property string $theme
 * @property boolean $current
 */
class Theme extends Model
{
    protected $table = 'themes';

    public $timestamps = false;

    protected $fillable = ['theme', 'current'];

    public static function boot(): void
    {
        parent::boot();

        static::creating(function ($instance) {
            if ($instance->current === true) {
                self::update(['current' => false]);
            }
        });

        static::updating(function ($instance) {
            if ($instance->current === true) {
                self::where('id', '!=', $instance->id)->update(['current' => false]);
            }
        });
    }
}
