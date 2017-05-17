<?php

namespace App\Traits;

use Illuminate\Http\Request;
use DB;

trait SuggestsProducts {

	/**
	 * Returns a collection of products based on the provided tag.
	 *
	 * @param  String $tag   product tag, whitespace separated values
	 * @param  int    $count number of suggestions to return
	 * @return array
	 */
	public function getProductSuggestions(String $tag, int $count)
	{
		$tags = explode(' ', $tag);
		
		return DB::table('products')
	}
}