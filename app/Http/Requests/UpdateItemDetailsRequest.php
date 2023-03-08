<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateItemDetailsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'color' => ['required', 'string', 'max:255'],
            'size' => ['required', 'string', 'max:255'],
            'stock' => ['required', 'integer', 'min:0'],
            'description' => ['required', 'string', 'max:255'],
        ];
    }
}
