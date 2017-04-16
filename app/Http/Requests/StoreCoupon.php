<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCoupon extends FormRequest
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
            'code'                 => 'required|max:255',
            'percentage'           => 'required_if:value,|max:255',
            'value'                => 'required_if:percentage,|max:255',
            'selected_product_ids' => 'required|max:255',
            'date_of_issue'        => 'required|date',
            'date_of_expiration'   => 'required|date',
        ];
    }
}
