<?php

namespace App\Support\Html;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Illuminate\Support\HtmlString open(array<array-key, mixed> $options = [])
 * @method static \Illuminate\Support\HtmlString model(mixed $model, array<array-key, mixed> $options = [])
 * @method static \Illuminate\Support\HtmlString close()
 * @method static \Illuminate\Support\HtmlString formInput(string $field, ?string $label, mixed $errors, array<array-key, mixed> $attributes)
 *
 * @see FormBuilder
 */
class Form extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return FormBuilder::class;
    }
}
