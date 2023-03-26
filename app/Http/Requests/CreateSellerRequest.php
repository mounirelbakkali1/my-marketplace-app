<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateSellerRequest extends FormRequest
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
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
            'password_confirmation' => 'required|same:password',
            //'image' => 'required|image',
            'websiteUrl' => 'required|url',
            'phone' => 'required|string',
            'street' => 'required|string',
            'zip_code' => 'required|string',
            'city' => 'required|string',
            'agree' => 'required',
        ];
    }


    public function messages()
    {
        return [
          'name.required' => 'the name field is required',
            'email.required' => 'the email field is required',
            'email.email' => 'the email field must be a valid email',
            'email.unique' => 'the email is already taken',
            'password.required' => 'the password field is required',
            'password.min' => 'the password must be at least 8 characters',
            'password_confirmation.required' => 'the password confirmation field is required',
            'password_confirmation.same' => 'the password confirmation must be the same as password',
            'image.required' => 'the image field is required',
            'image.image' => 'the image field must be an image',
            'websiteUrl.required' => 'the website url field is required',
            'websiteUrl.url' => 'the website url field must be a valid url',
            'phone.required' => 'the phone field is required',
            'street.required' => 'the street field is required',
            'zip_code.required' => 'the zip code field is required',
            'city.required' => 'the city field is required',
            'agree.required' => 'the agree field is required',
            'agree.accepted' => 'the agree field must be accepted',
        ];
    }
}
