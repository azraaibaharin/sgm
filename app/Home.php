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
        'about_text' => '',
        'tagline_title' => 'No title',
        'tagline_text' => 'No tagline', 
        'tagline_img' => 'feature-1.jpg', 
        'event_title' => 'No title',
        'event_text' => 'No event',
        'event_img' => 'feature-2.png', 
        'potm_title' => 'No title',
        'potm_text' => 'No product of the month',
        'potm_img' => 'feature-3.jpg',
        'facebook_url' => '', 
        'twitter_url' => '',
        'instagram_url' => '',
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
        'tagline_title', 'tagline_text', 'tagline_img', 
        'event_title', 'event_text', 'event_img', 
        'potm_title', 'potm_text', 'potm_img',
        'facebook_url', 'twitter_url', 'instagram_url',
        'contact_email',
    ];
}
