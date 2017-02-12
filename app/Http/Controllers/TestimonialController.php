<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Testimonial;
use App\Product;
use App\Http\Requests;
use App\Http\Requests\TestimonialFormRequest;
use App\Traits\FlashModelAttributes;
use App\Traits\FiltersTestimonial;

class TestimonialController extends Controller
{
    use FlashModelAttributes, FiltersTestimonial;

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
        $brands = $this->product->getBrands();
        $testimonials = [];
        
        if (is_null($brand))
        {
            $brand = $brands[0];
            $testimonials = $this->getTestimonials(50);
        } 
        else 
        {
            $testimonials = $this->getTestimonialsByBrand($brand);
        }

        $request->session()->flash('brand', $brand);

        return view('testimonial.index')
                ->with('testimonials', $testimonials)
                ->with('brands', $brands);
    }

    /**
     * Display a listing of resource based on selected filter.
     *
     * @return \Illumninate\Http\Response
     */
    public function filter(Request $request) 
    {
        $brands       = $this->product->getBrands();
        $brand        = $request->brand;
        $testimonials = [];
        
        if ($brand != $brands[0])
        {
            $testimonials = $this->getTestimonialsByBrand($brand);
        } 
        else 
        {
            $testimonials = $this->getTestimonials(50);
        }

        $request->session()->flash('brand', $brand);

        return view('testimonial.index')
                ->with('testimonials', $testimonials)
                ->with('brands', $brands);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('testimonial.create')->with('products', $this->product->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TestimonialFormRequest $request)
    {
        Log::info('Storing testimonial');

        $this->testimonial->product_id = $request->product_id;
        $this->testimonial->title      = $request->title;
        $this->testimonial->text       = $request->text;
        $this->testimonial->save();

        return redirect('testimonials/'.$this->testimonial->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Log::info('Showing testimonial id: '.$id);

        $testimonial = $this->testimonial->findOrFail($id);

        return view('testimonial.show')->with('testimonial', $testimonial);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        Log::info('Editing testimonial id: '.$id);

        $this->flashAttributesToSession($request, $this->testimonial->findOrFail($id));

        return view('testimonial.edit')->with('products', $this->product->all());
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
        Log::info('Updating testimonial id: '.$id);

        $testimonial             = $this->testimonial->findOrFail($id);
        $testimonial->product_id = $request['product_id'];
        $testimonial->title      = $request['title'];
        $testimonial->text       = $request['text'];

        $testimonial->save();

        return redirect('testimonials/'.$testimonial->id)->withMessage('Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Log::info('Removing testimonial id: '.$request->testimonial_id);

        $testimonialId    = $request->testimonial_id;
        $testimonial      = $this->testimonial->findOrFail($testimonialId);
        $testimonialTitle = $testimonial->title;

        $this->testimonial->destroy($testimonialId);

        return redirect('testimonials')->with('message', 'Successfully deleted \''.$testimonialTitle.'\'');
    }
}
