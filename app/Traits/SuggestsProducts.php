<?php

namespace App\Traits;

use Illuminate\Http\Request;
use DB;
use Log;

use App\Product;

trait SuggestsProducts {

	/**
	 * Returns a collection of products based on the provided tag.
	 *
	 * @param  Product $product instance of App\Product
	 * @return array
	 */
	public function getSuggestions(Product $product)
	{
		Log::info('Getting suggestions for product id: '.$product->id);
		$tag = $product->tag;
		if (!is_null($tag) && !empty($tag))
		{
			return Product::where('tag', 'LIKE', '%'.$tag.'%')
					->where('id', '!=', $product->id)
					->where('image_links', '!=', ',,,,')
					->orderBy('model', 'desc')
					->take(4)
					->get();
		} else 
		{
			return collect();
		}
	}
}