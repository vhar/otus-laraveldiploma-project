<?php

declare(strict_types=1);

namespace App\Orchid\Fields;

use Orchid\Screen\Field;

/**
 * Class ListField.
 *
 * @method $this name(string $value = null)
 * @method $this popover(string $value = null)
 * @method $this title(string $value = null)
 */
class ListField extends Field
{
    /**
     * @var string
     */
    protected $view = 'fields.list';

    /**
     * Default attributes value.
     *
     * @var array
     */
    protected $attributes = [
        'id'   => null,
        'list' => null,
    ];
}
