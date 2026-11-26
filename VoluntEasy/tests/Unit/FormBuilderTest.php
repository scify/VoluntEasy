<?php

namespace Tests\Unit;

use App\Support\Html\FormBuilder;
use Illuminate\Support\MessageBag;
use Tests\TestCase;

class FormBuilderTest extends TestCase
{
    private function form(): FormBuilder
    {
        return $this->app->make(FormBuilder::class);
    }

    public function test_open_adds_csrf_token_and_method_spoofing(): void
    {
        $html = (string) $this->form()->open(['url' => 'units/update', 'method' => 'PUT', 'files' => true]);

        $this->assertStringContainsString('method="POST"', $html);
        $this->assertStringContainsString('enctype="multipart/form-data"', $html);
        $this->assertStringContainsString('name="_token"', $html);
        $this->assertStringContainsString('name="_method"', $html);
        $this->assertStringContainsString('value="PUT"', $html);
    }

    public function test_value_comes_from_old_input_then_value_then_model(): void
    {
        $form = $this->form();
        $form->model((object) ['name' => 'From model', 'city' => 'Athens']);

        $this->session(['_old_input' => ['name' => 'From old input']]);
        $form = new FormBuilder($this->app['url'], $this->app['session.store']);
        $form->model((object) ['name' => 'From model', 'city' => 'Athens']);

        $this->assertStringContainsString('value="From old input"', (string) $form->text('name', 'Explicit'));
        $this->assertStringContainsString('value="Athens"', (string) $form->text('city'));
        $this->assertStringContainsString('value="Explicit"', (string) $form->text('country', 'Explicit'));
    }

    public function test_values_are_escaped(): void
    {
        $html = (string) $this->form()->text('name', '"><script>alert(1)</script>');

        $this->assertStringNotContainsString('<script>', $html);
        $this->assertStringContainsString('&quot;&gt;&lt;script&gt;', $html);
    }

    public function test_select_marks_the_selected_option(): void
    {
        $html = (string) $this->form()->select('gender_id', [0 => 'Choose', 1 => 'Female', 2 => 'Male'], 2);

        $this->assertStringContainsString('<option value="2" selected="selected">Male</option>', $html);
        $this->assertStringContainsString('<option value="1">Female</option>', $html);
    }

    public function test_form_input_renders_label_required_star_and_error(): void
    {
        $errors = new MessageBag(['email' => ['The email is invalid.']]);

        $html = (string) $this->form()->formInput('email', 'E-mail:', $errors, ['class' => 'form-control', 'required' => 'true']);

        $this->assertStringContainsString('<label for="email">E-mail:</label> <span class="star">*</span>', $html);
        $this->assertStringContainsString('id="email"', $html);
        $this->assertStringContainsString('The email is invalid.', $html);
        $this->assertStringStartsWith('<div class="has-error">', $html);
    }

    public function test_form_input_checkbox(): void
    {
        $html = (string) $this->form()->formInput('blacklisted', 'Blacklisted', null, ['type' => 'checkbox', 'value' => '1', 'checked' => 'true']);

        $this->assertStringContainsString('type="checkbox"', $html);
        $this->assertStringContainsString('checked="checked"', $html);
    }
}
