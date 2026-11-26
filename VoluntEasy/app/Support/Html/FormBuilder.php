<?php

namespace App\Support\Html;

use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\HtmlString;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Traits\Macroable;
use Illuminate\Support\ViewErrorBag;

/**
 * Small HTML form builder that keeps the API of the old illuminate/html
 * package, which the Blade views of VoluntEasy use.
 *
 * Value rules, in order: old input, the explicit value, the bound model.
 */
class FormBuilder
{
    use Macroable;

    /** @var list<string> Field names that already have a label. */
    protected array $labels = [];

    protected mixed $model = null;

    /** @var list<string> */
    protected array $spoofedMethods = ['DELETE', 'PATCH', 'PUT'];

    public function __construct(
        protected UrlGenerator $url,
        protected ?Session $session = null,
    ) {}

    /**
     * @param  array<array-key, mixed>  $options
     */
    public function open(array $options = []): HtmlString
    {
        $method = strtoupper((string) ($options['method'] ?? 'post'));

        $attributes = [
            'method' => $method !== 'GET' ? 'POST' : 'GET',
            'action' => $this->getAction($options),
            'accept-charset' => 'UTF-8',
        ];

        if (! empty($options['files'])) {
            $attributes['enctype'] = 'multipart/form-data';
        }

        $extra = array_diff_key($options, array_flip(['method', 'url', 'route', 'action', 'files']));
        $attributes = array_merge($attributes, $extra);

        $hidden = '';
        if ($method !== 'GET') {
            $hidden .= $this->token();
            if (in_array($method, $this->spoofedMethods, true)) {
                $hidden .= $this->hidden('_method', $method);
            }
        }

        return $this->html('<form'.$this->attributes($attributes).'>'.$hidden);
    }

    /**
     * @param  array<array-key, mixed>  $options
     */
    public function model(mixed $model, array $options = []): HtmlString
    {
        $this->model = $model;

        return $this->open($options);
    }

    public function close(): HtmlString
    {
        $this->labels = [];
        $this->model = null;

        return $this->html('</form>');
    }

    public function token(): HtmlString
    {
        return $this->hidden('_token', $this->session?->token());
    }

    /**
     * @param  array<array-key, mixed>  $options
     */
    public function label(string $name, ?string $value = null, array $options = []): HtmlString
    {
        $this->labels[] = $name;
        $value = e($value ?? ucwords(str_replace('_', ' ', $name)));

        return $this->html('<label for="'.e($name).'"'.$this->attributes($options).'>'.$value.'</label>');
    }

    /**
     * @param  array<array-key, mixed>  $options
     */
    public function input(string $type, ?string $name, mixed $value = null, array $options = []): HtmlString
    {
        if (! isset($options['name']) && $name !== null) {
            $options['name'] = $name;
        }

        $id = $this->getIdAttribute($name, $options);

        if (! in_array($type, ['file', 'password', 'checkbox', 'radio'], true)) {
            $value = $this->getValueAttribute($name, $value);
        }

        $options = array_merge(['type' => $type, 'value' => $value, 'id' => $id], $options);

        return $this->html('<input'.$this->attributes($options).'>');
    }

    /** @param array<array-key, mixed> $options */
    public function text(string $name, mixed $value = null, array $options = []): HtmlString
    {
        return $this->input('text', $name, $value, $options);
    }

    /** @param array<array-key, mixed> $options */
    public function password(string $name, array $options = []): HtmlString
    {
        return $this->input('password', $name, '', $options);
    }

    /** @param array<array-key, mixed> $options */
    public function hidden(string $name, mixed $value = null, array $options = []): HtmlString
    {
        return $this->input('hidden', $name, $value, $options);
    }

    /** @param array<array-key, mixed> $options */
    public function email(string $name, mixed $value = null, array $options = []): HtmlString
    {
        return $this->input('email', $name, $value, $options);
    }

    /** @param array<array-key, mixed> $options */
    public function file(string $name, array $options = []): HtmlString
    {
        return $this->input('file', $name, null, $options);
    }

    /** @param array<array-key, mixed> $options */
    public function textarea(string $name, mixed $value = null, array $options = []): HtmlString
    {
        if (! isset($options['name'])) {
            $options['name'] = $name;
        }

        $options['id'] = $this->getIdAttribute($name, $options);
        $value = (string) $this->getValueAttribute($name, $value);
        unset($options['size']);
        $options += ['cols' => 50, 'rows' => 10];

        return $this->html('<textarea'.$this->attributes($options).'>'.e($value).'</textarea>');
    }

    /**
     * @param  iterable<array-key, mixed>|null  $list
     * @param  array<array-key, mixed>  $options
     */
    public function select(string $name, ?iterable $list = [], mixed $selected = null, array $options = []): HtmlString
    {
        $selected = $this->getValueAttribute($name, $selected);
        $options['id'] = $this->getIdAttribute($name, $options);
        if (! isset($options['name'])) {
            $options['name'] = $name;
        }

        $html = [];
        foreach ($list ?? [] as $value => $display) {
            if (is_iterable($display)) {
                $group = [];
                foreach ($display as $groupValue => $groupDisplay) {
                    $group[] = $this->option($groupDisplay, $groupValue, $selected);
                }
                $html[] = '<optgroup label="'.e($value).'">'.implode('', $group).'</optgroup>';
            } else {
                $html[] = $this->option($display, $value, $selected);
            }
        }

        return $this->html('<select'.$this->attributes($options).'>'.implode('', $html).'</select>');
    }

    /** @param array<array-key, mixed> $options */
    public function checkbox(string $name, mixed $value = 1, ?bool $checked = null, array $options = []): HtmlString
    {
        return $this->checkable('checkbox', $name, $value, $checked, $options);
    }

    /** @param array<array-key, mixed> $options */
    public function radio(string $name, mixed $value = null, ?bool $checked = null, array $options = []): HtmlString
    {
        return $this->checkable('radio', $name, $value ?? $name, $checked, $options);
    }

    /** @param array<array-key, mixed> $options */
    public function submit(?string $value = null, array $options = []): HtmlString
    {
        return $this->input('submit', null, $value, $options);
    }

    /** @param array<array-key, mixed> $options */
    public function button(?string $value = null, array $options = []): HtmlString
    {
        $options += ['type' => 'button'];

        return $this->html('<button'.$this->attributes($options).'>'.($value ?? '').'</button>');
    }

    /**
     * Label, input and validation message for one field, in one call.
     *
     * Options that this method reads (and removes): "type" (text, password,
     * textarea, number, select, checkbox, radio, date, hidden, file),
     * "value", "key" (selected key of a select), "checked" and "required".
     *
     * @param  array<array-key, mixed>  $attributes
     */
    public function formInput(string $field, ?string $label, MessageBag|ViewErrorBag|null $errors, array $attributes): HtmlString
    {
        $labelHtml = $label !== null ? (string) $this->label($field, $label) : '';

        if (($attributes['required'] ?? null) == 'true') {
            $labelHtml .= ' <span class="star">*</span>';
        }
        unset($attributes['required']);

        $value = $attributes['value'] ?? null;
        unset($attributes['value']);

        $type = $attributes['type'] ?? 'text';
        unset($attributes['type']);

        $checked = ($attributes['checked'] ?? null) == 'true';
        unset($attributes['checked']);

        $inputHtml = match ($type) {
            'password' => $this->password($field, $attributes),
            'textarea' => $this->textarea($field, $value, $attributes),
            'number' => $this->input('number', $field, $value, $attributes),
            'select' => $this->selectFromFormInput($field, $value, $attributes),
            'checkbox' => $this->checkbox($field, $value, $checked, $attributes),
            'radio' => $this->radio($field, $value, $checked, $attributes),
            'date' => $this->input('date', $field),
            'hidden' => $this->hidden($field, null, $attributes),
            'file' => $this->file($field, $this->fileAttributes($attributes)),
            default => $this->text($field, $value, $attributes),
        };

        $errorKey = $field === 'files[]' ? 'files' : $field;
        $messageHtml = '';
        if ($errors !== null && $errors->has($errorKey)) {
            $messageHtml = '<p class="help-block invalid-feedback d-block">'.e($errors->first($errorKey)).'</p>';
        }

        $inner = $type === 'checkbox'
            ? $inputHtml.$labelHtml.$messageHtml
            : $labelHtml.$inputHtml.$messageHtml;

        return $this->html($messageHtml !== '' ? '<div class="has-error">'.$inner.'</div>' : $inner);
    }

    /** @param array<array-key, mixed> $attributes */
    protected function selectFromFormInput(string $field, mixed $values, array $attributes): HtmlString
    {
        $selected = $attributes['key'] ?? '';
        unset($attributes['key']);

        return $this->select($field, is_iterable($values) ? $values : [], $selected, $attributes);
    }

    /**
     * @param  array<array-key, mixed>  $attributes
     * @return array<array-key, mixed>
     */
    protected function fileAttributes(array $attributes): array
    {
        if (array_key_exists('multiple', $attributes)) {
            if ($attributes['multiple'] == 'true') {
                $attributes['multiple'] = true;
            } else {
                unset($attributes['multiple']);
            }
        }

        return $attributes;
    }

    /** @param array<array-key, mixed> $options */
    protected function checkable(string $type, string $name, mixed $value, ?bool $checked, array $options): HtmlString
    {
        $checked = $type === 'checkbox'
            ? $this->getCheckboxCheckedState($name, $value, $checked)
            : $this->getRadioCheckedState($name, $value, $checked);

        if ($checked) {
            $options['checked'] = 'checked';
        }

        if (! isset($options['name'])) {
            $options['name'] = $name;
        }
        $id = $this->getIdAttribute($name, $options);
        $options = array_merge(['type' => $type, 'value' => $value, 'id' => $id], $options);

        return $this->html('<input'.$this->attributes($options).'>');
    }

    protected function getCheckboxCheckedState(string $name, mixed $value, ?bool $checked): bool
    {
        if ($this->session !== null && $this->hasOldInput() && $this->old($name) === null) {
            return false;
        }

        if ($this->old($name) === null && $this->getModelValueAttribute($name) === null) {
            return (bool) $checked;
        }

        $posted = $this->getValueAttribute($name);

        return is_array($posted) ? in_array($value, $posted) : (bool) $posted;
    }

    protected function getRadioCheckedState(string $name, mixed $value, ?bool $checked): bool
    {
        if ($this->old($name) === null && $this->getModelValueAttribute($name) === null) {
            return (bool) $checked;
        }

        return $this->getValueAttribute($name) == $value;
    }

    protected function option(mixed $display, int|string $value, mixed $selected): string
    {
        $isSelected = is_array($selected)
            ? in_array((string) $value, array_map('strval', $selected), true)
            : $selected !== null && (string) $value === (string) $selected;

        $attributes = ['value' => (string) $value, 'selected' => $isSelected ? 'selected' : null];

        return '<option'.$this->attributes($attributes).'>'.e((string) $display).'</option>';
    }

    /** @param array<array-key, mixed> $options */
    protected function getIdAttribute(?string $name, array $options): ?string
    {
        if (array_key_exists('id', $options)) {
            return $options['id'] === null ? null : (string) $options['id'];
        }

        return $name !== null && in_array($name, $this->labels, true) ? $name : null;
    }

    public function getValueAttribute(?string $name, mixed $value = null): mixed
    {
        if ($name === null) {
            return $value;
        }

        $old = $this->old($name);
        if ($old !== null && $name !== '_method') {
            return $old;
        }

        if ($value !== null) {
            return $value;
        }

        return $this->getModelValueAttribute($name);
    }

    protected function getModelValueAttribute(string $name): mixed
    {
        if ($this->model === null) {
            return null;
        }

        return data_get($this->model, $this->transformKey($name));
    }

    public function old(string $name): mixed
    {
        return $this->session?->getOldInput($this->transformKey($name));
    }

    protected function hasOldInput(): bool
    {
        return count((array) $this->session?->getOldInput()) > 0;
    }

    protected function transformKey(string $key): string
    {
        return str_replace(['.', '[]', '[', ']'], ['_', '', '.', ''], $key);
    }

    /** @param array<array-key, mixed> $options */
    protected function getAction(array $options): string
    {
        if (isset($options['url'])) {
            return $this->url->to(...(array) $options['url']);
        }

        if (isset($options['route'])) {
            $route = (array) $options['route'];

            return $this->url->route($route[0], array_slice($route, 1));
        }

        if (isset($options['action'])) {
            $action = (array) $options['action'];

            return $this->url->action($action[0], array_slice($action, 1));
        }

        return $this->url->current();
    }

    /** @param array<array-key, mixed> $attributes */
    public function attributes(array $attributes): string
    {
        $html = [];
        foreach ($attributes as $key => $value) {
            if (is_numeric($key)) {
                $key = $value;
            }
            if ($value === null || $value === false) {
                continue;
            }
            if ($value === true) {
                $html[] = e((string) $key);

                continue;
            }
            $html[] = e((string) $key).'="'.e(is_scalar($value) ? (string) $value : '').'"';
        }

        return $html === [] ? '' : ' '.implode(' ', $html);
    }

    protected function html(string $html): HtmlString
    {
        return new HtmlString($html);
    }
}
