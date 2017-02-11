<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrder extends FormRequest
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
            'name' => 'required|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|max:255',
            'number' => 'required|max:255',
            'street' => 'required|max:255',
            'city' => 'required|max:255',
            'postcode' => 'required|max:255',
            'country' => 'required|max:255'
        ];
    }
}
