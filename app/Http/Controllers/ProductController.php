<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;
use Excel;

use App\Http\Requests;
use App\Product;
use Storage;

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
        $category = $request['category'];
        $categories = $product->getCategories();
        $brand = $request['brand'];
        $brands = $product->getBrands();
        $products = $product->when($brand != $brands[0], function ($query) use ($brand) {
                                return $query->where('brand', $brand);}
                            )->when($category != $categories[0], function ($query) use ($category) {
                                return $query->where('category', $category);}
                            )->orderBy('model', 'asc')->get();

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
    public function index(Request $request, $brand = null, $category = null)
    {   
        $product = $this->product;
        $brands = $product->getBrands();
        $categories = $product->getCategories();
        $products = [];

        if (!is_null($brand) && !empty($brand))
        {
            if (!is_null($category) && !empty($category))
            {
                $products = $product->where('brand', $brand)
                                    ->where('category', $category)
                                    ->orderBy('model', 'asc')
                                    ->get();
            } else 
            {
                $category = $categories[0];
                $products = $product->where('brand', $brand)
                                    ->orderBy('model', 'asc')
                                    ->get();
            }
        } 
        else
        {
            $brand = $brands[0];
            $category = $categories[0];
            $products = $product->orderBy('model', 'asc')
                                ->get();
        }

        return view('product.index')
                ->with('products', $products)
                ->with('brands', $brands)
                ->with('brand', $brand)
                ->with('categories', $categories)
                ->with('category', $category);
    }

    /**
     * Show the import products page.
     *
     * @return \Illuminate\Http\Response
     */
    public function import()
    {
        $this->middleware('auth');
        return view('product.import');
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
        $statuses = $product->getStatuses();

        return view('product.create')
                    ->with('brands', $brands)
                    ->with('categories', $categories)
                    ->with('statuses', $statuses);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = $this->save(
            $this->product, 
            $request['brand'], 
            $request['model'], 
            $request['price'], 
            $request['description'], 
            $request['status'], 
            '1', // category id
            strtolower($request['category']),
            $this->getImageLinks($request, $this->product), 
            $request['video_links'], 
            $request['color'], 
            $request['download_links'], 
            $request['weight'], 
            $request['dimension'], 
            $request['weight_capacity'], 
            $request['age_requirement'], 
            $request['awards']
        );

        return redirect('products/'.$product->id);
    }

    /**
     * Store resources based on imported file.
     *
     * @return [type] [description]
     */
    public function store2(Request $request)
    {
        if ($request->hasFile('csv_file'))
        {
            $csvFile = $request->file('csv_file');
            $csvFileName = 'products.'.$csvFile->getClientOriginalExtension();
            $csvFileMoved = $csvFile->move(storage_path('app/imports'), $csvFileName);

            $results = Excel::load($csvFileMoved->getRealPath())->get();

            // Loop through all sheets
            $rows = 0;
            $count = 0;
            $rowsNotProcessed = [];
            foreach($results as $sheet) 
            {
                // Loop through all rows
                foreach($sheet as $row) 
                {
                    if ($row->brand != null && $row->model !=null)
                    {
                        $product = $this->product->where('brand', $row->brand)->where('model', $row->model)->first();
                        if ($product == null) 
                        {
                            $product = new Product();
                        }

                        // if ($row->model == 'IVVI™ (Caviar)')
                        // {
                        //     dd($row);
                        // }

                        $this->save(
                            $product, 
                            strtolower($row->brand), 
                            $row->model, 
                            is_float($row->price_inclusive_gst) ? $row->price_inclusive_gst : 0.00, 
                            $row->description, 
                            $this->product->getStatuses()[0],  // status
                            '1', // category id
                            strtolower($row->category),
                            '', // image links
                            '', // video links
                            $row->colour, 
                            $row->download_links, 
                            $row->weight, 
                            $row->dimension, 
                            $row->weight_capacity, 
                            $row->age_requirement, 
                            $row->awards
                        );
                        $count++;
                    } else 
                    {
                        array_push($rowsNotProcessed, $row);
                    }
                    $rows++;
                };
            };

            Storage::delete('imports/'.$csvFileName);

            return redirect('products')->with('message','Import completed. '.$count.' products added. '.($rows - $count).' rows not processed.');
        } else
        {
            return redirect('products')->with('message','Import aborted. Import file not found.');
        }
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
        $productArr['colorsWithSku'] = explode(',', $productArr['color']);

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
        $productArr['image_fourth'] = $imagesArr[3];
        $productArr['image_fifth'] = $imagesArr[4];
        $brands = $product->getBrands(false);
        $categories = $product->getCategories(false);
        $statuses = $product->getStatuses();

        return view('product.edit', $productArr)
                    ->with('brands', $brands)
                    ->with('categories', $categories)
                    ->with('statuses', $statuses);
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

        $this->save($product, $request['brand'], $request['model'], $request['price'], $request['description'], $request['status'], '1', $request['category'], $this->getImageLinks($request, $product), $request['video_links'], $request['color'], $request['download_links'], $request['weight'], $request['dimension'], $request['weight_capacity'], $request['age_requirement'], $request['awards']);

        return back()->with('success','Update successful.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {  
        $product_id = $request['product_id'];
        $product = $this->product->findOrFail($product_id);
        $productName = $product->brand.' '.$product->model;
        $this->product->destroy($product_id);

        return redirect('products')->with('message', 'Successfully deleted \''.$productName.'\'');
    }

    /**
     * Save product.
     *
     * @param  [type] $product         [description]
     * @param  [type] $brand           [description]
     * @param  [type] $model           [description]
     * @param  [type] $price           [description]
     * @param  [type] $description     [description]
     * @param  [type] $status          [description]
     * @param  [type] $category_id     [description]
     * @param  [type] $category        [description] 
     * @param  [type] $image_links     [description]
     * @param  [type] $video_links     [description]
     * @param  [type] $color           [description]
     * @param  [type] $download_links  [description]
     * @param  [type] $weight          [description]
     * @param  [type] $dimension       [description]
     * @param  [type] $weight_capacity [description]
     * @param  [type] $age_requirement [description]
     * @param  [type] $awards          [description]
     * @return App/Product             [description]
     */
    protected function save($product, $brand, $model, $price, $description, $status, $category_id, $category, $image_links, $video_links, $color, $download_links, $weight, $dimension, $weight_capacity, $age_requirement, $awards)
    {
        $product->brand = $brand;
        $product->model = $model;
        $product->price = $price;
        $product->description = $description;
        $product->status = $status;
        $product->category_id = $category_id;
        $product->category = $category;
        $product->image_links = $image_links;
        $product->video_links = $video_links;
        $product->color = $this->cleanColor($color);
        $product->download_links = $download_links;
        $product->weight = $weight;
        $product->dimension = $dimension;
        $product->weight_capacity = $weight_capacity;
        $product->age_requirement = $age_requirement;
        $product->awards = $awards;
        $product->save();

        return $product;
    }

    /**
     * Format color string to (if more than 1 color is defined) to '<color_0> (<sku_0>), <color_1> (<sku_1>), <color_2> (<sku_2>)'.
     * E.g. Bisque(0101),Cinder (0201) , Green Mellow(9301) ,Yellow (8710)
     *      --> Bisque (0101), Cinder (0201), Green Mellow (9301), Yellow (8710)
     * 
     * @param  [type] $color [description]
     * @return [type]        [description]
     */
    private function cleanColor($color) {
        $colorArr = explode(',', $color);
        $cleanColorArr = [];

        foreach($colorArr as $c)
        {
            $cleanColor = $c;
            $matches = [];
            preg_match("#(.*).*\((.*)\)#", $c, $matches);
            if(sizeof($matches) == 3)
            {   
                $cleanColor = trim($matches[1]).' ('.trim($matches[2]).')';
            }
            array_push($cleanColorArr, $cleanColor);
        }

        return implode(', ', $cleanColorArr);
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
        $image_fourth_link = $this->imageUpload($request, 'image_fourth', $imagesArr[3], $image_prefix);
        $image_fifth_link = $this->imageUpload($request, 'image_fifth', $imagesArr[4], $image_prefix);

        return $image_first_link.','.$image_second_link.','.$image_third_link.','.$image_fourth_link.','.$image_fifth_link;
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
        $arr[3] = sizeof($imagesArr) > 3 ? $imagesArr[3] : '';
        $arr[4] = sizeof($imagesArr) > 4 ? $imagesArr[4] : '';

        return $arr;
    }

    /**
     * Manage Image upload Request
     *
     * @return void
     */
    protected function imageUpload(Request $request, $field_name, $old_value, $prefix)
    {
        $imageName = $old_value;

        if ($request->hasFile($field_name))
        {
            $this->validate($request, [
                $field_name => 'image|mimes:jpeg,png,jpg,gif,svg|max:10000',
            ]);

            $imageFile = $request->file($field_name);
            $imageName = $prefix.'_'.$field_name.'.'.$imageFile->getClientOriginalExtension();
            $imageMoved = $imageFile->move(public_path('img'), $imageName);

            $imgBig = Image::make($imageMoved->getRealPath())->heighten(2000)->save($this->getBigImagePath($imageName), 100);
            $imgSmall = Image::make($imageMoved->getRealPath())->heighten(560)->save($this->getSmallImagePath($imageName), 100);
            $imgTiny = Image::make($imageMoved->getRealPath())->heighten(60)->save($this->getTinyImagePath($imageName), 100);
        }

        return $imageName;
    }

    /**
     * Return full file path for product tiny image.
     *
     * @param  String $imageName name of the image
     * @return String            full file path of the image
     */
    private function getTinyImagePath($imageName) 
    {
        return public_path('img').'/tiny_'.$imageName;
    }

    /**
     * Return full file path for product small image.
     *
     * @param  String $imageName name of the image
     * @return String            full file path of the image
     */
    private function getSmallImagePath($imageName) 
    {
        return public_path('img').'/small_'.$imageName;   
    }

    /**
     * Return full file path for product big image.
     *
     * @param  String $imageName name of the image
     * @return String            full file path of the image
     */
    private function getBigImagePath($imageName) 
    {
        return public_path('img').'/big_'.$imageName;
    }
}
