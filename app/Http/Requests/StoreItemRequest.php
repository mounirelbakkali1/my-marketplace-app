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
            'description'=> 'required|string',
            'price' => 'required|numeric|min:0',
            'primary_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => 'required',
            'collection_id' => 'required',
            'condition' => 'required|in:' . implode(',', ItemCondition::getValues()),
            'color' => 'required|string',
            'size' => 'required|string',
            'stock' => 'required|numeric|min:0',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Name is required',
            'name.string' => 'Name must be a string',
            'name.max' => 'Name must be less than 255 characters',
            'description.required' => 'Description is required',
            'description.string' => 'Description must be a string',
            'price.required' => 'Price is required',
            'price.numeric' => 'Price must be a number',
            'price.min' => 'Price must be greater than 0',
            'primary_image.required' => 'Primary image is required',
            'primary_image.image' => 'Primary image must be an image',
            'primary_image.mimes' => 'Primary image must be a file of type: jpeg, png, jpg, gif, svg',
            'primary_image.max' => 'Primary image may not be greater than 2048 kilobytes',
            'category_id.required' => 'Category is required',
            'collection_id.required' => 'Collection is required',
            'condition.required' => 'Condition is required',
            'condition.in' => 'Condition must be one of the following: ' . implode(',', ItemCondition::getValues()),
            'color.required' => 'Colors is required',
            'color.string' => 'Colors must be a string',
            'size.required' => 'Size is required',
            'size.string' => 'Size must be a string',
            'stock.required' => 'Stock is required',
            'stock.numeric' => 'Stock must be a number',
            'stock.min' => 'Stock must be greater than 0',
        ];
    }


}

