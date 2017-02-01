<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormSubmitted;
use App\Http\Requests\ContactFormRequest;
use App\Home;
use App\Article;
use App\Configuration;

use DB;

class HomeController extends Controller
{

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
    public function __construct(Home $home, Article $article, Configuration $configuration)
    {
        $this->home = $home;
        $this->article = $article;
        $this->configuration = $configuration;

        if (is_null($this->home->first()))
        {
            $this->home->about_text = 'New about lah';
            $this->home->save();
        }

        $shippingRatePerKiloConfig = $this->configuration->where('key', $this->shippingRatePerKiloKey)->first();
        if (is_null($shippingRatePerKiloConfig))
        {
            $shippingRatePerKiloConfig = $this->configuration;
            $shippingRatePerKiloConfig->key = $this->shippingRatePerKiloKey;
            $shippingRatePerKiloConfig->value = '0.00';
            $shippingRatePerKiloConfig->save;
        }
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $latestTestimonialBabyhood = DB::table('testimonials')
                                ->join('products', 'products.id', '=', 'testimonials.product_id')
                                ->select('testimonials.*', 'products.brand', 'products.model')
                                ->where('products.brand', 'babyhood')
                                ->orderBy('created_at')
                                ->take(1)
                                ->first();

        $latestTestimonialNuna = DB::table('testimonials')
                            ->join('products', 'products.id', '=', 'testimonials.product_id')
                            ->select('testimonials.*', 'products.brand', 'products.model')
                            ->where('products.brand', 'nuna')
                            ->orderBy('created_at')
                            ->take(1)
                            ->first();

        $articles = $this->article
                    ->orderBy('created_at', 'asc')
                    ->take(3)
                    ->get();

        return view('home', $this->getData())
                ->with('latestTestimonialBabyhood', $latestTestimonialBabyhood)
                ->with('latestTestimonialNuna', $latestTestimonialNuna)
                ->with('articles', $articles);
    }

    /**
     * Display edit home page.
     * 
     */
    protected function edit()
    {
        return view('home.edit', $this->getData());
    }

    /**
     * Updates home page data.
     *
     * @return void
     */
    protected function update(Request $request)
    {
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

        $shippingRatePerKiloConfig = $this->configuration->where('key', $this->shippingRatePerKiloKey)->first();
        if (is_null($shippingRatePerKiloConfig))
        {
            $shippingRatePerKiloConfig = new Configuration();
            $shippingRatePerKiloConfig->key = $this->shippingRatePerKiloKey;
        }
        $shippingRatePerKiloConfig->value = $request[$this->shippingRatePerKiloKey];
        $shippingRatePerKiloConfig->save();

        return redirect('/');
    }

    /**
     * Manage Post Request
     *
     * @return void
     */
    protected function imageUpload(Request $request, $field_name, $old_value)
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
            $request['contact_name'],
            $request['contact_email'],
            $request['contact_message']
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
        $shippingRatePerKiloConfig = $this->configuration->where('key', $this->shippingRatePerKiloKey)->first();
        $shippingRatePerKiloValue = 0.00;
        if (!is_null($shippingRatePerKiloConfig))
        {
            $shippingRatePerKiloValue = $shippingRatePerKiloConfig->value;
        }
        
        $data = $this->home->first()->toArray();
        $data[$this->shippingRatePerKiloKey] = $shippingRatePerKiloValue;

        return $data;
    }
}
