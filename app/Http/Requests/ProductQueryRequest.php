<?php

namespace App\Http\Requests;

use App\Enums\ProductFields;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductQueryRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'skip' => [
                'sometimes',
                'integer',
                'min:0',
                'max:1000'
            ],
            'limit' => [
                'sometimes',
                'integer',
                'min:1',
                'max:1000'
            ],
            'search' => [
                'nullable',
                'string'
            ],
            'select' => [
                'sometimes',
                Rule::enum(ProductFields::class)
            ],
            'sortBy' => [
                'sometimes',
                'string',
                Rule::enum(ProductFields::class)
                    ->only([
                        ProductFields::ID,
                        ProductFields::TITLE,
                        ProductFields::PRICE,
                        ProductFields::DISCOUNT_PERCENTAGE,
                        ProductFields::RATING,
                        ProductFields::STOCK,
                    ])
            ],
            'order' => [
                'required_with:sortBy',
                'string',
                Rule::in(['asc', 'desc'])
            ]
        ];
    }
}
