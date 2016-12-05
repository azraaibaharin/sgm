<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Testimonial;
use App\Product;
use App\Http\Requests;
use App\Http\Requests\TestimonialFormRequest;

class TestimonialController extends Controller
{

    /**
     * The Testimonial instance.
     * @var App\Testimonial
     */
    protected $testimonial;

    /**
     * The Product instance.
     * @var App\Product
     */
    protected $product;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Testimonial $testimonial, Product $product)
    {
        $this->testimonial = $testimonial;
        $this->product = $product;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $brand = null)
    {
        $testimonials = $this->testimonial->take(50)->orderBy('created_at')->get();
        $brands = $this->product->getBrands();
        $brand = !is_null($brand) && !empty($brand) ? $brands[0] : $brand;

        return view('testimonial.index')
                ->with('testimonials', $testimonials)
                ->with('brands', $brands)
                ->with('brand', $brand);
    }

    /**
     * Display a listing of resource based on selected filter.
     *
     * @return \Illumninate\Http\Response
     */
    public function filter(Request $request) 
    {
        $brands = $this->product->getBrands();
        $brand = $request['brand'];

        $testimonial = $this->testimonial;
        $testimonials = $testimonial->whereHas('comments', function ($query) {
            $query->where('content', 'like', 'foo%');
        })->get();

        $testimonials = $testimonial->when($brand != $brands[0], function ($query) use ($brand) {
                            return $query->where('brand', $brand);
                        })->orderBy('model', 'asc')->get();

        return view('product.index')
                ->with('testimonials', $testimonials)
                ->with('brands', $brands)
                ->with('brand', $brand)
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = $this->product->all();
        return view('testimonial.create')
                ->with('products', $products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TestimonialFormRequest $request)
    {
        $testimonial = $this->testimonial;

        $testimonial->product_id = $request['product_id'];
        $testimonial->title = $request['title'];
        $testimonial->text = $request['text'];
        $testimonial->save();

        return redirect('testimonials/'.$testimonial->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $testimonial = $this->testimonial->find($id);
        if (is_null($testimonial))
        {
            return redirect('testimonials')->with('message', 'Testimonial not found.');
        }
        return view('testimonial.show')
                ->with('testimonial', $testimonial)
                ->with('product', $testimonial->product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $testimonial = $this->testimonial->find($id);
        if (is_null($testimonial))
        {
            return redirect('testimonials')->with('message', 'Testimonial not found.');
        }
        $products = $this->product->all();
        return view('testimonial.edit', $testimonial->toArray())
                ->with('products', $products);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TestimonialFormRequest $request, $id)
    {
        $testimonial = $this->testimonial->find($id);
        if (is_null($testimonial))
        {
            return redirect('testimonial')->with('message', 'Testimonial not found.');
        }

        $testimonial->product_id = $request['product_id'];
        $testimonial->title = $request['title'];
        $testimonial->text = $request['text'];
        $testimonial->save();

        return back()->with('success','Update successful.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $testimonial_id = $request['testimonial_id'];
        $testimonial = $this->testimonial->findOrFail($testimonial_id);
        $testimonialTitle = $testimonial->title;
        $this->testimonial->destroy($testimonial_id);

        return redirect('testimonials')->with('message', 'Successfully deleted \''.$testimonialTitle.'\'');
    }
}
