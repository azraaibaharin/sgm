<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Product;

class ProductController extends Controller
{
    /**
     * The Product instance.
     * @var App\product
     */
    protected $product;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Product $product)
    {
        $this->middleware('auth');

        $this->product = $product;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->product->all();

        return view('product.index')->with('products', $products);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = $this->product;

        $product->brand = $request['brand'];
        $product->model = $request['model'];
        $product->description = $request['description'];
        $product->category_id = '1';
        $product->image_links = $this->getImageLinks($request, $product);
        $product->video_links = $request['video_links'];
        $product->color = $request['color'];
        $product->download_links = $request['download_links'];
        $product->weight = $request['weight'];
        $product->dimension = $request['dimension'];
        $product->weight_capacity = $request['weight_capacity'];
        $product->age_requirement = $request['age_requirement'];
        $product->awards = $request['awards'];

        $product->save();

        return redirect('products');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $productArr = $this->product->find($id)->toArray();
        return view('product.show', $productArr );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $productArr = $this->product->find($id)->toArray();
        $imagesArr = explode(',', $productArr['image_links']);

        $productArr['image_first'] = sizeof($imagesArr) > 0 ? $imagesArr[0] : '';
        $productArr['image_second'] = sizeof($imagesArr) > 1 ? $imagesArr[1] : '';
        $productArr['image_third'] = sizeof($imagesArr) > 2 ? $imagesArr[2] : '';

        return view('product.edit', $productArr);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = $this->product->find($id);

        $product->brand = $request['brand'];
        $product->model = $request['model'];
        $product->description = $request['description'];
        $product->category_id = '1';
        $product->image_links = $this->getImageLinks($request, $product);
        $product->video_links = $request['video_links'];
        $product->color = $request['color'];
        $product->download_links = $request['download_links'];
        $product->weight = $request['weight'];
        $product->dimension = $request['dimension'];
        $product->weight_capacity = $request['weight_capacity'];
        $product->age_requirement = $request['age_requirement'];
        $product->awards = $request['awards'];

        // dd($product);

        $product->save();

        return back()->with('success','Update successful.');
    }

    /**
     * Returns comma separated links to uploaded images.
     * 
     * @return String           comma separated links to uploaded images
     */
    private function getImageLinks(Request $request, Product $product)
    {   
        $imagesArr = explode(',', $product->image_links);

        $image_first_old = sizeof($imagesArr) > 0 ? $imagesArr[0] : '';
        $image_second_old = sizeof($imagesArr) > 1 ? $imagesArr[1] : '';
        $image_third_old = sizeof($imagesArr) > 2 ? $imagesArr[2] : '';

        $image_prefix = $product->brand.'_'.$product->model;
        $image_first_link = $this->imageUpload($request, 'image_first', $image_first_old, $image_prefix);
        $image_second_link = $this->imageUpload($request, 'image_second', $image_second_old, $image_prefix);
        $image_third_link = $this->imageUpload($request, 'image_third', $image_third_old, $image_prefix);

        return $image_first_link.','.$image_second_link.','.$image_third_link;
    }

    /**
     * Manage Post Request
     *
     * @return void
     */
    public function imageUpload(Request $request, $field_name, $old_value, $prefix)
    {
        $imageName = $old_value;

        if ($request->hasFile($field_name))
        {
            $this->validate($request, [
                $field_name => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $image = $request->file($field_name);
            $imageName = $prefix.'_'.$field_name.'.'.$image->getClientOriginalExtension();
            $image->move(public_path('img'), $imageName);
        }

        return $imageName;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
