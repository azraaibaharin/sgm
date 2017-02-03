<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait FlashModelAttributes {
	/**
     * Iterates each attributes of a model instance and flash the value to next session.
     *
     * @param  Request $request
     * @param  Model $model   
     * @return void
     */
    public function flashAttributesToSession(Request $request, $model)
    {
        foreach ($model->toArray() as $key => $value) {
            $request->session()->flash($key, $value);
        }
    }
}