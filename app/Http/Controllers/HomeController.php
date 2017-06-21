<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use File;

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
     * The configuration keys for east Malaysia shipping rates.
     * @var string
     */
    protected $shippingRateEastPerKiloKey = 'shipping_rate_east_per_kilo';
    protected $shippingRateEastMinChargeKey = 'shipping_rate_east_min_charge';
    protected $shippingRateEastMinWeightKey = 'shipping_rate_east_min_weight';

    /**
     * The configuration keys for west Malaysia shipping rates.
     * @var string
     */
    protected $shippingRateWestPerKiloKey = 'shipping_rate_west_per_kilo';
    protected $shippingRateWestMinChargeKey = 'shipping_rate_west_min_charge';
    protected $shippingRateWestMinWeightKey = 'shipping_rate_west_min_weight';

    /**
     * The configuration key for sales team email.
     * @var string
     */
    protected $emailSalesKey = 'email_sales';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Home $home, Article $article, Testimonial $testimonial, Product $product, Configuration $configuration)
    {
        $this->home          = $home;
        $this->article       = $article;
        $this->testimonial   = $testimonial;
        $this->product       = $product;
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
        $this->configuration->firstOrCreate(['key' => $this->shippingRateEastPerKiloKey]);
        $this->configuration->firstOrCreate(['key' => $this->shippingRateEastMinChargeKey]);
        $this->configuration->firstOrCreate(['key' => $this->shippingRateEastMinWeightKey]);
        $this->configuration->firstOrCreate(['key' => $this->shippingRateWestPerKiloKey]);
        $this->configuration->firstOrCreate(['key' => $this->shippingRateWestMinChargeKey]);
        $this->configuration->firstOrCreate(['key' => $this->shippingRateWestMinWeightKey]);
        $this->configuration->firstOrCreate(['key' => $this->emailSalesKey]);

        $babyhoodIds = $this->product->where('brand', 'babyhood')->pluck('id');
        $nunaIds     = $this->product->where('brand', 'nuna')->pluck('id');

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
        session()->flash($this->shippingRateEastPerKiloKey, $this->configuration->shippingRateEastPerKilo()->first()->value);
        session()->flash($this->shippingRateEastMinChargeKey, $this->configuration->shippingRateEastMinCharge()->first()->value);
        session()->flash($this->shippingRateEastMinWeightKey, $this->configuration->shippingRateEastMinWeight()->first()->value);
        session()->flash($this->shippingRateWestPerKiloKey, $this->configuration->shippingRateWestPerKilo()->first()->value);
        session()->flash($this->shippingRateWestMinChargeKey, $this->configuration->shippingRateWestMinCharge()->first()->value);
        session()->flash($this->shippingRateWestMinWeightKey, $this->configuration->shippingRateWestMinWeight()->first()->value);
        session()->flash($this->emailSalesKey, $this->configuration->emailSales()->first()->value);

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

        $home->nuna_text              = $request['nuna_text'];
        $home->nuna_img               = $this->imageUpload($request, 'nuna_img', $home->nuna_img);
        $home->babyhood_text          = $request['babyhood_text'];
        $home->about_text             = $request['about_text'];
        $home->babyhood_img           = $this->imageUpload($request, 'babyhood_img', $home->babyhood_img);
        $home->tagline_title          = $request['tagline_title'];
        $home->tagline_text           = $request['tagline_text'];
        $home->tagline_link           = $request['tagline_link'];
        $home->tagline_link_text      = $request['tagline_link_text'];
        $home->tagline_img            = $this->imageUpload($request, 'tagline_img', $home->tagline_img);
        $home->event_title            = $request['event_title'];
        $home->event_text             = $request['event_text'];
        $home->event_link             = $request['event_link'];
        $home->event_link_text        = $request['event_link_text'];
        $home->event_img              = $this->imageUpload($request, 'event_img', $home->event_img);
        $home->potm_title             = $request['potm_title'];
        $home->potm_text              = $request['potm_text'];
        $home->potm_link              = $request['potm_link'];
        $home->potm_link_text         = $request['potm_link_text'];
        $home->potm_img               = $this->imageUpload($request, 'potm_img', $home->potm_img);
        $home->facebook_babyhood_url  = $request['facebook_babyhood_url'];
        $home->instagram_babyhood_url = $request['instagram_babyhood_url'];
        $home->facebook_nuna_url      = $request['facebook_nuna_url'];
        $home->instagram_nuna_url     = $request['instagram_nuna_url'];
        $home->contact_email          = $request['contact_email'];
        $home->save();

        $configShippingEastPerKilo        = $this->configuration->shippingRateEastPerKilo()->first();
        $configShippingEastPerKilo->value = $request->shipping_rate_east_per_kilo;
        $configShippingEastPerKilo->save();

        $configShippingEastMinCharge        = $this->configuration->shippingRateEastMinCharge()->first();
        $configShippingEastMinCharge->value = $request->shipping_rate_east_min_charge;
        $configShippingEastMinCharge->save();

        $configShippingEastMinWeight        = $this->configuration->shippingRateEastMinWeight()->first();
        $configShippingEastMinWeight->value = $request->shipping_rate_east_min_weight;
        $configShippingEastMinWeight->save();

        $configShippingWestPerKilo        = $this->configuration->shippingRateWestPerKilo()->first();
        $configShippingWestPerKilo->value = $request->shipping_rate_west_per_kilo;
        $configShippingWestPerKilo->save();

        $configShippingWestMinCharge        = $this->configuration->shippingRateWestMinCharge()->first();
        $configShippingWestMinCharge->value = $request->shipping_rate_west_min_charge;
        $configShippingWestMinCharge->save();

        $configShippingWestMinWeight        = $this->configuration->shippingRateWestMinWeight()->first();
        $configShippingWestMinWeight->value = $request->shipping_rate_west_min_weight;
        $configShippingWestMinWeight->save();

        $configEmailSales        = $this->configuration->emailSales()->first();
        $configEmailSales->value = $request->email_sales;
        $configEmailSales->save();

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
            $imageName = $field_name.'-'.Carbon::now()->timestamp.'.'.$image->getClientOriginalExtension();
            $image->move(public_path('img'), $imageName);

            // remove the old image file
            if (file_exists(public_path('img').'/'.$old_value)) {
                File::delete(public_path('img').'/'.$old_value);
                Log::info('Deleted old image file: '.$old_value);
            } else {
                Log::info('Old image file not found: '.$old_value);
            }
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
