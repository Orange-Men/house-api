<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetHouse extends FormRequest
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
            'name' => 'string',
            'price' => 'array',
            'price.0'  => 'required_with:price|numeric|min:0',
            'price.1'  => 'required_with:price.0|numeric|min:0',
            'bedrooms' => 'integer|min:0',
            'bathrooms' => 'integer|min:0',
            'storeys' => 'integer|min:0',
            'garages' => 'integer|min:0'
        ];
    }
}
