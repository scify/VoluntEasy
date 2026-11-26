<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Base form request. Access control is done by the "auth" middleware of the
 * controllers, so every request that reaches validation is authorized.
 */
abstract class Request extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
}
