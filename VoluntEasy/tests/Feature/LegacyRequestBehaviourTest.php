<?php

namespace Tests\Feature;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull;
use Tests\TestCase;

class LegacyRequestBehaviourTest extends TestCase
{
    public function test_empty_form_fields_stay_empty_strings(): void
    {
        // Several NOT NULL columns (for example volunteers.fathers_name) get ""
        // from optional form fields. Converting "" to null breaks the insert.
        $this->assertNotContains(
            ConvertEmptyStringsToNull::class,
            $this->app->make(Kernel::class)->getGlobalMiddleware(),
        );
    }
}
