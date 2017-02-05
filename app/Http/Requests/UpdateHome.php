<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class UpdateHome extends FormRequest
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
            'nuna_text' => 'required',
            'nuna_img' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'about_text' => 'required',
            'babyhood_text' => 'required',
            'babyhood_img' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'tagline_title' => 'required|max:255',
            'tagline_text' => '',
            'tagline_img' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'event_title' => 'required|max:255',
            'event_text' => '',
            'event_img' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'potm_title' => 'required|max:255',
            'potm_text' => '',
            'potm_img' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'facebook_babyhood_url' => 'required|max:255',
            'facebook_nuna_url' => 'required|max:255',
            'instagram_babyhood_url' => 'required|max:255',
            'instagram_nuna_url' => 'required|max:255',
            'contact_email' => 'required|max:255',
            'shipping_rate_per_kilo' => 'required|max:255'
        ];
    }
}
