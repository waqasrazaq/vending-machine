<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class AddInventoryItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'item_name' => 'required|string',
            'item_price' => 'required|numeric|gt:0',
            'item_count' => 'required|numeric|gte:0',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'item_name.required' => config('common.error_inventory_item_name_required'),
            'item_name.string' => config('common.error_inventory_item_name_string'),
            'item_price.required' => config('common.error_inventory_item_price_required'),
            'item_price.numeric' => config('common.error_inventory_item_price_numeric'),
            'item_price.gt' => config('common.error_inventory_item_price_numeric'),
            'item_count.required' => config('common.error_inventory_item_count_required'),
            'item_count.numeric' => config('common.error_inventory_item_count_numeric'),
            'item_count.gte' => config('common.error_inventory_item_count_numeric'),
        ];
    }

    /**
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(response()->json(['errors' => $errors
        ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY));
    }
}
