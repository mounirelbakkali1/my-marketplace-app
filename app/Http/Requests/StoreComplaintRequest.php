<?php

namespace App\Http\Requests;

use App\Enums\ComplaintType;
use Illuminate\Foundation\Http\FormRequest;

class StoreComplaintRequest extends FormRequest
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
            'user_id' => 'required|integer|exists:users,id',
            'complaint' => 'required|string',
            'complaint_type' => 'required|in:' . implode(',', ComplaintType::getValues()),
        ];
    }
}
