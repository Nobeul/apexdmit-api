<?php

namespace App\Traits;

use App\Support\StatusCode;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException as LaravelValidationException;

trait ValidationException
{
    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'status' => 'error',
            'message' => 'Validation failed.',
            'errors' => $validator->errors(),
        ], StatusCode::UNPROCESSABLE_ENTITY);

        throw new LaravelValidationException($validator, $response);
    }
}
