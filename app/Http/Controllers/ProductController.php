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
     * Display a listing of resource based on selected filter.
     *
     * @return \Illumninate\Http\Response
     */
    public function filter(Request $request) 
    {
        $product = $this->product;

        $brands = $product->getBrands();
        $categories = $product->getCategories();

        $brand = $request['brand'];
        $category = $request['category'];

        $products = $product
                        ->when($brand != $brands[0], function ($query) use ($brand) {
                            return $query->where('brand', $brand);
                        })
                        ->when($category != $categories[0], function ($query) use ($category) {
                            return $query->where('category', $category);
                        })
                        ->orderBy('model', 'asc')
                        ->get();

        return view('product.index')
                ->with('products', $products)
                ->with('brands', $brands)
                ->with('brand', $brand)
                ->with('categories', $categories)
                ->with('category', $category);

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $brand = null)
    {   
        $product = $this->product;

        $brands = $product->getBrands();
        $categories = $product->getCategories();

        $products = [];
        if (!is_null($brand) && !empty($brand))
        {
            $products = $product->where('brand', $brand)
                                ->orderBy('model', 'asc')
                                ->take(15)
                                ->get();
        } else
        {
            $brand = $brands[0];
            $products = $product->orderBy('model', 'asc')
                                ->take(15)
                                ->get();
        }

        return view('product.index')
                ->with('products', $products)
                ->with('brands', $brands)
                ->with('brand', $brand)
                ->with('categories', $categories)
                ->with('category', $categories[0]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product = $this->product;

        $brands = $product->getBrands(false);
        $categories = $product->getCategories(false);

        return view('product.create')
                    ->with('brands', $brands)
                    ->with('categories', $categories);
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

        return redirect('products/'.$product->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $product = $this->product->find($id);
        if (is_null($product))
        {
            return redirect('products')->with('message', 'Product not found.');
        }
        $productArr = $product->toArray();

        return view('product.show', $productArr)
                ->with('displayImage', $product->getDisplay('image_links'))
                ->with('displayVideo', $product->getDisplay('video_links'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = $this->product->find($id);
        if (is_null($product))
        {
            return redirect('products')->with('message', 'Product not found.');
        }
        $productArr = $product->toArray();
        $imagesArr = $this->getImageArr($productArr['image_links']);

        $productArr['image_first'] = $imagesArr[0];
        $productArr['image_second'] = $imagesArr[1];
        $productArr['image_third'] = $imagesArr[2];

        $brands = $product->getBrands(false);
        $categories = $product->getCategories(false);

        return view('product.edit', $productArr)
                    ->with('brands', $brands)
                    ->with('categories', $categories);
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
        if (is_null($product))
        {
            return redirect('products')->with('message', 'Product not found.');
        }

        $product->brand = $request['brand'];
        $product->model = $request['model'];
        $product->description = $request['description'];
        $product->category_id = '1';
        $product->category = $request['category'];
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

        return back()->with('success','Update successful.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $this->product->destroy($id);

        return redirect('products')->with('message', 'Deleted succesfully.');
    }

    /**
     * Returns comma separated links to uploaded images.
     * 
     * @return String           comma separated links to uploaded images
     */
    private function getImageLinks(Request $request, Product $product)
    {   
        $imagesArr = $this->getImageArr($product->image_links);  

        $image_prefix = $product->brand.'_'.$product->model;
        $image_first_link = $this->imageUpload($request, 'image_first', $imagesArr[0], $image_prefix);
        $image_second_link = $this->imageUpload($request, 'image_second', $imagesArr[1], $image_prefix);
        $image_third_link = $this->imageUpload($request, 'image_third', $imagesArr[2], $image_prefix);

        return $image_first_link.','.$image_second_link.','.$image_third_link;
    }

    /**
     * Returns an array of product image links.
     * 
     * @param  String $image_links comma separated image links
     * @return array            an array of product image links
     */
    private function getImageArr(String $image_links)
    {
        $imagesArr = explode(',', $image_links);

        $arr[0] = sizeof($imagesArr) > 0 ? $imagesArr[0] : '';
        $arr[1] = sizeof($imagesArr) > 1 ? $imagesArr[1] : '';
        $arr[2] = sizeof($imagesArr) > 2 ? $imagesArr[2] : '';

        return $arr;
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
}
