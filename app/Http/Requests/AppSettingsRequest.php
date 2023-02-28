<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AppSettingsRequest extends FormRequest
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
            'social_media_links' => 'required|json',
            'contact_info' => 'required|json',
            'about_us' => 'required|string|max:5000',
            'terms_and_conditions' => 'required|string|max:5000',
            'privacy_policy' => 'required|string|max:5000',
            'faq' => 'required|json',
        ];
    }
}
