<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class StoreProduct extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return !Auth::guest();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'brand' => 'required', 
            'model' => 'required',
            'price' => 'required',
            'description' => 'required', 
            'status' => '',
            'category' => 'required',
            'color' => 'required', 
            'weight' => 'required', 
            'dimension' => 'required', 
            'weight_capacity' => 'required', 
            'age_requirement' => 'required',
            'delivery_weight' => 'required',
            'sort_index' => 'required',
        ];
    }
}
