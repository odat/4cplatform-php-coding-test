<?php

namespace App\Http;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class Request
 *
 * @package App\Http
 * @codeCoverageIgnore
 */
class Request extends FormRequest
{
    /**
     * Determine if the current request is asking for JSON in return.
     *
     * @return bool
     */
    public function wantsJson(): bool
    {
        return true;
    }

    /**
     * Determine if the current request probably expects a JSON response.
     *
     * @return bool
     */
    public function expectsJson(): bool
    {
        return true;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }
}
