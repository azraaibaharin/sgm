<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
	/**
	 * The attributes default values.
	 * 
	 * @var array
	 */
    protected $attributes = [
    	'title' => '',
    	'text' => '',
    	'link' => '',
    	'author' => ''
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    	'title', 'text', 'link', 'author'
    ];
}
