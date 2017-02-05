<?php

namespace App\Traits;

use Illuminate\Http\Request;
use DB;

trait FiltersTestimonial {
	
    /**
     * Returns a collection of testimonials filtered by product brand and ordered by created date.
     * 
     * @param  String $brand product brand
     * @return Collection filtered testimonials
     */
    public function getLatestTestimonialsByBrand(String $brand, int $count)
    {
        return DB::table('testimonials')
                    ->join('products', 'products.id', '=', 'testimonials.product_id')
                    ->select('testimonials.*', 'products.brand', 'products.model')
                    ->where('products.brand', $brand)
                    ->orderBy('created_at')
                    ->take($count)
                    ->get();
    }

    /**
     * Returns a collection of testimonials filtered by product brand.
     * 
     * @param  String $brand product brand
     * @return Collection filtered testimonials
     */
    public function getTestimonialsByBrand(String $brand)
    {
        return DB::table('testimonials')
                    ->join('products', 'products.id', '=', 'testimonials.product_id')
                    ->select('testimonials.*', 'products.brand', 'products.model')
                    ->where('products.brand', $brand)
                    ->orderBy('created_at')
                    ->get();
    }

    /**
     * Returns all testimonials ordered by created date.
     *
     * @param  $count number of rows to retrieve
     * @return [type] [description]
     */
    public function getTestimonials(int $count)
    {
        return DB::table('testimonials')
                    ->join('products', 'products.id', '=', 'testimonials.product_id')
                    ->select('testimonials.*', 'products.brand', 'products.model')
                    ->orderBy('created_at')
                    ->take($count)
                    ->get();
    }
}