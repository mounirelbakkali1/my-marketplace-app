<?php

namespace App\Http\Requests;

use App\Enums\ItemCondition;
use Illuminate\Foundation\Http\FormRequest;

class UpdateItemRequest extends FormRequest
{
    private $storeItemRequest;


    public function __construct(StoreItemRequest $storeItemRequest)
    {
        $this->storeItemRequest = $storeItemRequest;
    }
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
            'name' => 'string|max:255',
            'description'=> 'string',
            'price' => 'numeric|min:0',
           // 'primary_image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'category_id' => '',
            'collection_id' => '',
            'condition' => 'in:' . implode(',', ItemCondition::getValues()),
            'color' => 'string',
            'size' => 'string',
            'stock' => 'numeric|min:0',
        ];
    }
}
