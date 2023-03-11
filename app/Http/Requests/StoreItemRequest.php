<?php

namespace App\Http\Requests;

use App\Enums\ItemCondition;
use App\Enums\ItemStatus;
use Illuminate\Foundation\Http\FormRequest;

class StoreItemRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            //'primary_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required',
            'status' => 'required|in:' . implode(',', ItemStatus::getValues()),
            'collection_id' => 'required',
            'seller_id' => 'required',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'required|string|max:255',
            'price.required' => 'required|numeric|min:0',
            //'primary_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id.required' => 'required',
            'status.required' => 'required|in:' . implode(',', ItemStatus::getValues()),
            'collection_id.required' => 'required',
            'seller_id.required' => 'required',
        ];
    }


}

