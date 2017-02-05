<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

use App\Mail\ContactFormSubmitted;
use App\Http\Requests\ContactFormRequest;
use App\Http\Requests\UpdateHome;
use App\Traits\FlashModelAttributes;
use App\Home;
use App\Article;
use App\Testimonial;
use App\Product;
use App\Configuration;

class HomeController extends Controller
{
    use FlashModelAttributes;

    /**
     * The Home instance.
     * @var App\Home
     */
    protected $home;

    /**
     * The Article instance.
     * @var App\Article
     */
    protected $article;

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
     * A list of product Ids with the brand as the key.
     * @var Collectiom
     */
    protected $productBrandIds;

    /**
     * The Configuration instance.
     * @var App\Configuration
     */
    protected $configuration;

    /**
     * The configuration key for shipping rate per kilo.
     * @var string
     */
    protected $shippingRatePerKiloKey = 'shipping_rate_per_kilo';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Home $home, Article $article, Testimonial $testimonial, Product $product, Configuration $configuration)
    {
        $this->home = $home;
        $this->article = $article;
        $this->testimonial = $testimonial;
        $this->product = $product;
        $this->configuration = $configuration;

        $this->init();
    }

    /**
     * Initialize values.
     *
     * @return void
     */
    private function init()
    {
        $this->configuration->firstOrCreate(['key' => $this->shippingRatePerKiloKey, 'value' => '0.00']);
        $babyhoodIds = $this->product->where('brand', 'babyhood')->pluck('id');
        $nunaIds = $this->product->where('brand', 'nuna')->pluck('id');
        $this->productBrandIds = collect(['babyhood' => $babyhoodIds,'nuna' => $nunaIds]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home', $this->getData())
                ->with('latestTestimonialBabyhood', $this->getLatestTestimonial('babyhood'))
                ->with('latestTestimonialNuna', $this->getLatestTestimonial('nuna'))
                ->with('articles', $this->getLatestArticles());
    }

    /**
     * Return the latest 3 articles.
     *
     * @return array
     */
    private function getLatestArticles()
    {
        return $this->article->orderBy('created_at', 'desc')->take(3)->get();
    }

    /**
     * Return the latest testimonial by brand name.
     *
     * @param  String $brand brand name
     * @return \App\Testimonial
     */
    private function getLatestTestimonial(String $brand)
    {
        $ids = $this->productBrandIds->get($brand);

        return $this->testimonial->whereIn('product_id', $ids)->orderBy('created_at', 'desc')->first();
        
    }

    /**
     * Display edit home page.
     *
     * @param $request \Illuminate\Http\Request;
     * @return  void
     */
    protected function edit(Request $request)
    {
        $this->flashAttributesToSession($request, $this->home->firstOrFail());
        session()->flash('shipping_rate_per_kilo', $this->configuration->where('key', $this->shippingRatePerKiloKey)->first()->value);

        return view('home.edit');
    }

    /**
     * Updates home page data.
     *
     * @return void
     */
    protected function update(UpdateHome $request)
    {
        Log::info('Updating home page.');
        $home = $this->home->first();

        $home->nuna_text = $request['nuna_text'];
        $home->nuna_img = $this->imageUpload($request, 'nuna_img', $home->nuna_img);
        $home->babyhood_text = $request['babyhood_text'];
        $home->about_text = $request['about_text'];
        $home->babyhood_img = $this->imageUpload($request, 'babyhood_img', $home->babyhood_img);
        $home->tagline_title = $request['tagline_title'];
        $home->tagline_text = $request['tagline_text'];
        $home->tagline_img = $this->imageUpload($request, 'tagline_img', $home->tagline_img);
        $home->event_title = $request['event_title'];
        $home->event_text = $request['event_text'];
        $home->event_img = $this->imageUpload($request, 'event_img', $home->event_img);
        $home->potm_title = $request['potm_title'];
        $home->potm_text = $request['potm_text'];
        $home->potm_img = $this->imageUpload($request, 'potm_img', $home->potm_img);
        $home->facebook_babyhood_url = $request['facebook_babyhood_url'];
        $home->instagram_babyhood_url = $request['instagram_babyhood_url'];
        $home->facebook_nuna_url = $request['facebook_nuna_url'];
        $home->instagram_nuna_url = $request['instagram_nuna_url'];
        $home->contact_email = $request['contact_email'];
        $home->save();

        $configuration = $this->configuration->where('key', $this->shippingRatePerKiloKey)->first();
        $configuration->value = $request->shipping_rate_per_kilo;
        $configuration->save();

        return back()->withMessage("Update successful!");
    }

    /**
     * Manage Post Request
     *
     * @return void
     */
    private function imageUpload(Request $request, $field_name, $old_value)
    {
        $imageName = $old_value;

        if ($request->hasFile($field_name))
        {
            $this->validate($request, [
                $field_name => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

            $image = $request->file($field_name);
            $imageName = $field_name.'.'.$image->getClientOriginalExtension();
            $image->move(public_path('img'), $imageName);
        }

        return $imageName;
    }

    /**
     * Process contact inquiry.
     *
     * @param  ContactFormRequest $request contact form request type
     * @return void
     */
    protected function contact(ContactFormRequest $request) {
        $contactEmail = $this->home->firstOrFail()->contact_email;
        
        Mail::to($contactEmail)->send(new ContactFormSubmitted(
            $request->contact_name,
            $request->contact_email,
            $request->contact_message
        ));

        return redirect('/')->with('message', 'Thanks for contacting us!');
    }

    /**
     * Get data for home views.
     * 
     * @return an array of Home attributes' value
     */
    private function getData()
    {    
        return $this->home->first()->toArray();
    }
}
