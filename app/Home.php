<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Home extends Model
{
    /**
     * The attributes default values.
     * 
     * @var array
     */
	protected $attributes = [
		'nuna_text' => '', 
		'nuna_img' => '', 
        'babyhood_text' => '', 
        'babyhood_img' => '', 
        'about_text' => 'About you',
        'tagline_title' => 'No title',
        'tagline_text' => 'No tagline', 
        'tagline_img' => 'feature-1.jpg', 
        'tagline_link' => '', 
        'tagline_link_text' => '', 
        'event_title' => 'No title',
        'event_text' => 'No event',
        'event_img' => 'feature-2.png', 
        'event_link' => '', 
        'event_link_text' => '', 
        'potm_title' => 'No title',
        'potm_text' => 'No product of the month',
        'potm_img' => 'feature-3.jpg',
        'potm_link' => '',
        'potm_link_text' => '',
        'facebook_babyhood_url' => '', 
        'instagram_babyhood_url' => '',
        'facebook_nuna_url' => '', 
        'instagram_nuna_url' => '',
        'contact_email' => 'amir@babyhood.com.my',
	];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nuna_text', 'nuna_img', 
        'babyhood_text', 'babyhood_img', 
        'about_text',
        'tagline_title', 'tagline_text', 'tagline_img', 'tagline_link', 'tagline_link_text', 
        'event_title', 'event_text', 'event_img', 'event_link', 'event_link_text', 
        'potm_title', 'potm_text', 'potm_img', 'potm_link', 'potm_link_text',
        'facebook_babyhood_url', 'instagram_babyhood_url', 'facebook_nuna_url', 'instagram_nuna_url',
        'contact_email',
    ];
}
