<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Image;
use Excel;
use Log;
use File;
use Carbon\Carbon;

use App\Http\Requests\StoreProduct;
use App\Traits\FlashModelAttributes;
use App\Traits\SuggestsProducts;
use App\Http\Requests;
use App\Product;
use Storage;

class ProductController extends Controller
{
    use FlashModelAttributes, SuggestsProducts;

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
        Log::info('Searching product brand: '.$request->brand.' of category: '.$request->category);

        $brand    = $request->brand;
        $category = $request->category;
        $products = $this->product->ofBrandAndCategory($brand, $category)->get();

        return view('product.index')
                ->with('brands', $this->product->getBrands())
                ->with('categories', $this->product->getCategories())
                ->with('brand', $brand)
                ->with('category', $category)
                ->with('products', $products);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $brand = null, $category = null)
    {   
        $brands     = $this->product->getBrands();
        $categories = $this->product->getCategories();
        $products   = $this->product->ofBrandAndCategory($brand, $category)->get();

        if (is_null($brand)) 
        {
            $brand = $brands[0];
        }       

        if (is_null($category))
        {
            $category = $categories[0];
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
        return view('product.import');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {   
        $request->session()->flash('brands', $this->product->getBrands(false));
        $request->session()->flash('categories', $this->product->getCategories(false));
        $request->session()->flash('statuses', $this->product->getStatuses());
        $request->session()->flash('visibility', ['true', 'false']);
        $request->session()->flash('is_sale_opts', ['yes', 'no']);

        return view('product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProduct $request)
    {
        Log::info('Storing product');

        $product = $this->save(
            $this->product, 
            $request->brand, 
            $request->model, 
            $request->price, 
            $request->description, 
            $request->status, 
            '1', // category id
            strtolower($request->category),
            $this->getImageLinks($request, $this->product), 
            $request->video_links, 
            $request->color, 
            $request->download_links, 
            $request->weight, 
            $request->delivery_weight,
            $request->dimension, 
            $request->weight_capacity,
            $request->age_requirement, 
            $request->awards,
            $request->visible,
            $request->tag,
            $request->sort_index,
            $request->is_sale
        );

        return redirect('products/'.$product->id);
    }

    /**
     * Store resources based on imported file.
     *
     * @return void
     */
    public function store2(Request $request)
    {
        Log::info('Importing products');

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
                        $product = is_null($product) ? $this->product : $product;

                        $this->save(
                            $product, 
                            strtolower($row->brand), 
                            is_null($product->model) ? $row->model : $product->model, 
                            is_float($row->price_inclusive_gst) ? $row->price_inclusive_gst : 0.00, 
                            is_null($product->description) ? $row->description : $product->description, 
                            is_null($product->status) ? $this->product->getStatuses()[0] : $product->status,
                            '1', // category id
                            is_null($product->category) ? strtolower($row->category) : $product->category,
                            is_null($product->image_links) ? ',,,,' : $product->image_links, 
                            is_null($product->video_links) ? '' : $product->video_links,
                            is_null($product->colour) ? $row->colour : $product->colour, 
                            is_null($product->download_links) ? $row->download_links : $product->download_links, 
                            is_null($product->weight) ? $row->weight : $product->weight, 
                            is_null($row->delivery_weight) ? 0.00 : $row->delivery_weight,
                            is_null($product->dimension) ? $row->dimension : $product->dimension, 
                            is_null($product->weight_capacity) ? $row->weight_capacity : $product->weight_capacity, 
                            is_null($product->age_requirement) ? $row->age_requirement : $product->age_requirement, 
                            is_null($product->awards) ? $row->awards : $product->awards,
                            'true',
                            '',
                            0,
                            false
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
        Log::info('Showing product id:'.$id);

        $product    = $this->product->findOrFail($id);
        $productArr = $product->toArray();

        $productArr['colorsWithSku'] = explode(',', $productArr['color']);

        return view('product.show', $productArr)
                ->with('displayImage', $product->getDisplay('image_links'))
                ->with('displayVideo', $product->getDisplay('video_links'))
                ->with('suggestions', $this->getSuggestions($product));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        Log::info('Editing product id: '.$id);

        $product = $this->product->findOrFail($id);

        $this->flashAttributesToSession($request, $product);

        $images = $this->getImages($product->image_links);
        $request->session()->flash('image_first', $images[0]);
        $request->session()->flash('image_second', $images[1]);
        $request->session()->flash('image_third', $images[2]);
        $request->session()->flash('image_fourth', $images[3]);
        $request->session()->flash('image_fifth', $images[4]);
        $request->session()->flash('brands', $product->getBrands(false));
        $request->session()->flash('categories', $product->getCategories(false));
        $request->session()->flash('statuses', $product->getStatuses());
        $request->session()->flash('visibility', ['true', 'false']);
        $request->session()->flash('is_sale_opts', ['yes', 'no']);

        return view('product.edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreProduct $request, $id)
    {
        Log::info('Updating product id: '.$id);

        $product = $this->product->findOrFail($id);

        $this->save(
            $product, 
            $request->brand, 
            $request->model, 
            $request->price, 
            $request->description, 
            $request->status, 
            '1', // category_id
            $request->category, 
            $this->getImageLinks($request, $product), 
            $request->video_links, 
            $request->color, 
            $request->download_links, 
            $request->weight, 
            $request->delivery_weight, 
            $request->dimension, 
            $request->weight_capacity, 
            $request->age_requirement, 
            $request->awards,
            $request->visible,
            $request->tag,
            $request->sort_index,
            $request->is_sale
        );

        return redirect('products/'.$product->id)->withMessage('Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {  
        Log::info('Removing product id: '.$request->product_id);

        $productId   = $request->product_id;
        $product     = $this->product->findOrFail($productId);
        $productName = $product->brand.' '.$product->model;

        $this->product->destroy($productId);

        return redirect('products')->withMessage('Deleted \''.$productName.'\'');
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
     * @param  [type] $delivery_weight [description]
     * @param  [type] $dimension       [description]
     * @param  [type] $weight_capacity [description]
     * @param  [type] $age_requirement [description]
     * @param  [type] $awards          [description]
     * @param  [type] $visible         [description]
     * @param  [type] $tag             [description]
     * @param  [type] $sort_index      [description]
     * @param  [type] $is_sale         [description]
     * @return App/Product             [description]
     */
    protected function save($product, $brand, $model, $price, $description, $status, $category_id, $category, $image_links, $video_links, $color, $download_links, $weight, $delivery_weight, $dimension, $weight_capacity, $age_requirement, $awards, $visible, $tag, $sort_index, $is_sale)
    {
        $product->brand           = $brand;
        $product->model           = $model;
        $product->price           = $price;
        $product->description     = $description;
        $product->status          = $status;
        $product->category_id     = $category_id;
        $product->category        = $category;
        $product->image_links     = $image_links;
        $product->video_links     = $video_links;
        $product->color           = $this->cleanColor($color);
        $product->download_links  = $download_links;
        $product->weight          = $weight;
        $product->delivery_weight = $delivery_weight;
        $product->dimension       = $dimension;
        $product->weight_capacity = $weight_capacity;
        $product->age_requirement = $age_requirement;
        $product->awards          = $awards;
        $product->visible         = $visible == 'true';
        $product->tag             = $tag;
        $product->sort_index      = $sort_index;
        $product->is_sale         = $is_sale == 'yes';

        $product->save();

        return $product;
    }

    /**
     * Remove image based on the image index.
     * 
     * @param  Request $request the post request that contains information of the image index to remove
     * @param  String  $id      the product id of the image to remove
     * @return response to the edit product page
     */
    public function removeImage(Request $request, String $id)
    {
        Log::info('Removing image of product id: '.$id);

        $product = $this->product->findOrFail($id);

        $imageLinks = $product->image_links;
        $imageLinksArr = explode(',', $imageLinks);
        $imageLinksSize = sizeof($imageLinksArr);
        Log::info('Product with id: '.$id.' has '.$imageLinksSize.' images.');
        
        $imageIndex = $request->image_index;
        Log::info('Image index to remove is: '.$imageIndex);
            
        $toRemoveImageLink = $imageLinksArr[$imageIndex];
        if (!empty($toRemoveImageLink) && !is_null($toRemoveImageLink))
        {
            Log::info("To remove image link: ".$toRemoveImageLink);
            Log::info('Image links before removal: '.$imageLinks);
            $imageLinks = str_replace($toRemoveImageLink, "", $imageLinks);
            Log::info('Image links after removal: '.$imageLinks);

            $product->image_links = $imageLinks;
            $product->save();

            Log::info('Product image links: '.$product->image_links);

            $this->removeImageFiles($toRemoveImageLink);
        } else 
        {
            Log::info('Invalid to remove image links found');
        }

        return redirect('products/'.$product->id.'/edit')->withMessage('Image removed!');
    }

    /**
     * Remove all files related to the image based on the filename.
     * 
     * @param  String $filename the image file name to remove
     * @return void
     */
    public function removeImageFiles(String $filename)
    {
        $this->removeImageFile($filename);
        $this->removeImageFile($this->getBigImageName($filename));
        $this->removeImageFile($this->getSmallImageName($filename));
        $this->removeImageFile($this->getTinyImageName($filename));
    }

    /**
     * Remove image file.
     *
     * @param filename the name of file to remove
     */
    public function removeImageFile(String $filename)
    {
        if (file_exists(public_path('img').'/'.$filename)) {
            File::delete(public_path('img').'/'.$filename);
            Log::info('Deleted old image file: '.$filename);
        } else {
            Log::info('Old image file not found: '.$filename);
        }
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
        $cleanColorArr = [];

        foreach(explode(',', $color) as $c)
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
        $images       = $this->getImages($product->image_links);
        $image_prefix = $this->getImagePrefix($product);

        $image_first_link  = $this->imageUpload($request, 'image_first', $images[0], $image_prefix);
        $image_second_link = $this->imageUpload($request, 'image_second', $images[1], $image_prefix);
        $image_third_link  = $this->imageUpload($request, 'image_third', $images[2], $image_prefix);
        $image_fourth_link = $this->imageUpload($request, 'image_fourth', $images[3], $image_prefix);
        $image_fifth_link  = $this->imageUpload($request, 'image_fifth', $images[4], $image_prefix);

        return $image_first_link.','.$image_second_link.','.$image_third_link.','.$image_fourth_link.','.$image_fifth_link;
    }

    /**
     * Return constructed image prefix based on product brand and model.
     *
     * @param  Product $product 
     * @return String constructed image prefix
     */
    private function getImagePrefix(Product $product)
    {
        return $this->cleanString($product->brand.'_'.$product->model);
    }

    /**
     * Return cleaned string. 
     * Replace whitespace with underscore '_'. 
     * Convert to lowercase.
     *
     * @param  String $string the string to clean
     * @return String the cleaned string
     */
    private function cleanString(String $string)
    {
        $cleanedString = str_replace(' ', '_', $string);
        $cleanedString = str_replace('/', '_', $cleanedString);
        $cleanedString = strtolower($cleanedString);
        return $cleanedString;
    }

    /**
     * Returns an array of product image links.
     * 
     * @param  String $image_links comma separated image links
     * @return array            an array of product image links
     */
    private function getImages(String $image_links)
    {
        $images = explode(',', $image_links);
        $arr[0] = sizeof($images) > 0 ? $images[0] : '';
        $arr[1] = sizeof($images) > 1 ? $images[1] : '';
        $arr[2] = sizeof($images) > 2 ? $images[2] : '';
        $arr[3] = sizeof($images) > 3 ? $images[3] : '';
        $arr[4] = sizeof($images) > 4 ? $images[4] : '';

        return $arr;
    }

    /**
     * Manage Image upload Request. Create 3 images (big, small, tiny).
     *
     * @return uploaded image name
     */
    private function imageUpload(Request $request, $field_name, $old_value, $prefix)
    {
        $imageName = $old_value;

        if ($request->hasFile($field_name))
        {
            $this->validate($request, [
                $field_name => 'image|mimes:jpeg,png,jpg,gif,svg|max:10000',
            ]);

            $imageFile  = $request->file($field_name);
            $imageName  = $prefix.'_'.$field_name.'-'.Carbon::now()->timestamp.'.'.$imageFile->getClientOriginalExtension();
            $imageMoved = $imageFile->move(public_path('img'), $imageName);

            $imgBig   = Image::make($imageMoved->getRealPath())->heighten(2000)->save($this->getBigImagePath($imageName), 100);
            $imgSmall = Image::make($imageMoved->getRealPath())->heighten(560)->save($this->getSmallImagePath($imageName), 100);
            $imgTiny  = Image::make($imageMoved->getRealPath())->heighten(60)->save($this->getTinyImagePath($imageName), 100);

            $this->removeImageFiles($old_value);
        }

        return $imageName;
    }

    /**
     * Return full file name for product tiny image.
     *
     * @param  String $imageName    name of the image
     * @return String            full file name of the image
     */
    private function getTinyImageName($imageName) 
    {
        return '/tiny_'.$imageName;
    }

    /**
     * Return full file path for product tiny image.
     *
     * @param  String $imageName    name of the image
     * @return String            full file path of the image
     */
    private function getTinyImagePath($imageName) 
    {
        return public_path('img').$this->getTinyImageName($imageName);
    }

    /**
     * Return full file name for product small image.
     *
     * @param  String $imageName    name of the image
     * @return String            full file name of the image
     */
    private function getSmallImageName($imageName) 
    {
        return '/small_'.$imageName;   
    }

    /**
     * Return full file path for product small image.
     *
     * @param  String $imageName    name of the image
     * @return String            full file path of the image
     */
    private function getSmallImagePath($imageName) 
    {
        return public_path('img').$this->getSmallImageName($imageName);   
    }

    /**
     * Return full file name for product big image.
     *
     * @param  String $imageName    name of the image
     * @return String            full file name of the image
     */
    private function getBigImageName($imageName) 
    {
        return '/big_'.$imageName;
    }

    /**
     * Return full file path for product big image.
     *
     * @param  String $imageName    name of the image
     * @return String            full file path of the image
     */
    private function getBigImagePath($imageName) 
    {
        return public_path('img').$this->getBigImageName($imageName);
    }
}
