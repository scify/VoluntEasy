<?php

namespace Tests\Support;

use Illuminate\Testing\TestResponse;

/**
 * Submit a form of the application as a browser does: take the fields from
 * the rendered page, keep their current values, choose the first real option
 * of each dropdown, then apply the values that the test sets.
 */
trait SubmitsForms
{
    /**
     * @param  array<string, mixed>  $values
     */
    protected function submitForm(string $pageUrl, array $values, int $formIndex = 0): TestResponse
    {
        $html = $this->get($pageUrl)->assertOk()->getContent();

        $dom = new \DOMDocument;
        @$dom->loadHTML('<?xml encoding="utf-8"?>'.$html);
        $form = $dom->getElementsByTagName('form')->item($formIndex);
        $this->assertNotNull($form, "No form {$formIndex} on {$pageUrl}");

        $data = [];
        foreach ((new \DOMXPath($dom))->query('.//input|.//select|.//textarea', $form) as $field) {
            /** @var \DOMElement $field */
            $name = $field->getAttribute('name');
            if ($name === '' || str_contains($name, '[')) {
                continue;
            }
            $type = strtolower($field->getAttribute('type'));
            if (in_array($type, ['submit', 'button', 'file'], true)) {
                continue;
            }
            if (in_array($type, ['checkbox', 'radio'], true)) {
                if ($field->hasAttribute('checked')) {
                    $data[$name] = $field->getAttribute('value');
                }

                continue;
            }
            $data[$name] = match ($field->tagName) {
                'select' => $this->selectedOption($field),
                'textarea' => $field->textContent,
                default => $field->getAttribute('value'),
            };
        }

        $action = $form->getAttribute('action');

        return $this->post($action, array_merge($data, $values));
    }

    private function selectedOption(\DOMElement $select): string
    {
        $first = null;
        foreach ($select->getElementsByTagName('option') as $option) {
            /** @var \DOMElement $option */
            if ($option->hasAttribute('selected')) {
                return $option->getAttribute('value');
            }
            if ($first === null && ! in_array($option->getAttribute('value'), ['', '0'], true)) {
                $first = $option->getAttribute('value');
            }
        }

        return $first ?? '';
    }
}
