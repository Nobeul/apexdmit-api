<?php

namespace App\Http\Requests;

use App\Traits\ValidationException;
use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    use ValidationException;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ];
    }
}
