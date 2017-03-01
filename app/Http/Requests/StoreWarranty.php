<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWarranty extends FormRequest
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
            'full_name'             => 'required|max:255',
            'email'                 => 'required|email|max:255',
            'phone_number'          => 'required|max:255',
            'address'               => 'required|max:255',
            'product_model_name'    => 'required|max:255',
            'product_serial_number' => 'required|max:255',
            'date_of_manufacture'   => 'required|date',
            'date_of_purchase'      => 'required|date',
        ];
    }
}
