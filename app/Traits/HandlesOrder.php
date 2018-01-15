<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Log;
use Storage;

use App\Traits\HandlesCoupon;
use App\Traits\HandlesCart;
use App\Mail\OrderSubmitted;
use App\Mail\OrderSupportSubmitted;
use App\Order;
use App\Configuration;
use Cart;

trait HandlesOrder {

	use HandlesCart;

	protected $orderNameKey = 'order_name';
	protected $orderEmailKey = 'order_email';
    protected $orderPhoneNumberKey = 'order_phone_number';
    protected $orderAddressKey = 'order_address';
    protected $orderShoppingCartIdKey = 'order_shopping_cart_id';
    protected $orderReferenceNumberKey = 'order_reference_number';
    protected $orderDeliveryCostKey = 'order_delivery_cost';
    protected $orderTotalPriceKey = 'order_total_price';
    protected $orderFinalPriceKey = 'order_final_price';

    /**
     * States of east Malaysia.
     * @var array
     */
    protected $eastStates = [
        'Sabah',
        'Sarawak',
        'Labuan'
    ];

    /**
     * States of west Malaysia.
     * @var array
     */
    protected $westStates = [
        'Johor',
        'Kedah',
        'Kelantan',
        'Malacca',
        'Negeri Sembilan',
        'Pahang',
        'Penang',
        'Perak',
        'Perlis',
        'Selangor',
        'Terengganu',
        'Kuala Lumpur',
        'Putrajaya'
    ];

    /**
     * Send email of Order details to sales.
     *
     * @param  Request $request 
     * @return void
     */
    public function sendEmail(Request $request, $order, $message = '')
    {
    	$salesEmail = is_null(Configuration::emailSales()->first()) ? 'sales@babyhood.com.my' : Configuration::emailSales()->first()->value;

        Log::info($message.' Send email notification to sales team: '.$salesEmail.'. Ref noL '.$order->reference_number);

        Mail::to($salesEmail)->send(new OrderSubmitted(
        	$order,
        	Cart::content()
       	));
    }

    /**
     * Send email of Order details to support.
     *
     * @param  Request $request 
     * @return void
     */
    public function sendSupportEmail(Request $request, $order, $message = '')
    {
        $supportEmail = 'dominoseffect@gmail.com';

        Log::info($message.' Send debugging information to support team: '.$supportEmail.'. Ref no: '.$order->reference_number);

        Mail::to($supportEmail)->send(new OrderSupportSubmitted(
            $order,
            Cart::content()
        ));
    }

    /**
     * Stores order details to a file.
     *
     * @param  [type] $order [description]
     * @return [type]        [description]
     */
    public function storeToFile($order)
    {
        // $contents = file_get_contents(storage_path('app/orders/').'order-template.txt');
        $template = Storage::disk('local')->get('orders/order-template.txt');
        $template = str_replace('{{ id }}', $order->id, $template);
        $template = str_replace('{{ reference_number }}', $order->reference_number, $template);
        $template = str_replace('{{ status }}', $order->status, $template);
        $template = str_replace('{{ name }}', $order->name, $template);
        $template = str_replace('{{ email }}', $order->email, $template);
        $template = str_replace('{{ phone_number }}', $order->phone_number, $template);
        $template = str_replace('{{ address }}', $order->address, $template);
        $template = str_replace('{{ contents }}', $this->getCartContentString(), $template);
        $template = str_replace('{{ total_price }}', $order->address, $template);
        $template = str_replace('{{ coupon_total_value }}', $order->coupon_total_value, $template);
        $template = str_replace('{{ delivery_cost }}', $order->delivery_cost, $template);
        $template = str_replace('{{ final_price }}', $order->final_price, $template);

        Log::info('Storing order details for support team at '.storage_path('app/orders/').$order->reference_number.'.txt');

        Storage::disk('local')->put('orders/'.$order->reference_number.'.txt', $template);
    }

    /**
     * Get converted cart content rows to string.
     * @return String cart contents
     */
    private function getCartContentString()
    {
        $contentString = '';
        foreach (Cart::content() as $row) {
            $contentString = $contentString.$row->name.' - '.$row->options['color'].' | '.$row->qty.' | RM'.$row->total;
            $contentString = $contentString."\r";
        }
        return $contentString;
    }

    /**
     * Save order details to session.
     *
     * @param  Request $request
     * @return void
     */
    public function saveToSession(Request $request)
    {
    	Log::info('Saving order values to session');

    	$request->session()->put($this->orderNameKey, $request->name);
    	$request->session()->put($this->orderEmailKey, $request->email);
    	$request->session()->put($this->orderPhoneNumberKey, $request->phone_number);
    	$request->session()->put($this->orderAddressKey, $this->constructAddress($request));
        $request->session()->put($this->orderDeliveryCostKey, $this->calculateDeliveryCost($request));
        $request->session()->put($this->orderShoppingCartIdKey, $this->getShoppingCartId());
        $request->session()->put($this->orderTotalPriceKey, Cart::total(2, '.', ''));
        $request->session()->put($this->orderFinalPriceKey, $this->calculateFinalPrice($request));
        $request->session()->put($this->orderReferenceNumberKey, $this->constructReferenceNumber());
    }

    /**
     * Store Order details to database from session.
     *
     * @param  Request $request
     * @param  String $status 			the order status
     * @param  String $referenceNumber 	the order reference number
     * @return App/Order the Order instance
     */
    public function storeFromSession(Request $request, String $status, String $referenceNumber)
    {
    	Log::info('Storing order with reference number: '.$referenceNumber.' to database with values from session.');

    	$order = new Order;

    	$order->status             = $status;
    	$order->reference_number   = $referenceNumber;
    	$order->name               = $request->session()->get($this->orderNameKey);
    	$order->email              = $request->session()->get($this->orderEmailKey);
    	$order->phone_number       = $request->session()->get($this->orderPhoneNumberKey);
    	$order->address            = $request->session()->get($this->orderAddressKey);
    	$order->delivery_cost      = $request->session()->get($this->orderDeliveryCostKey);
        $order->shoppingcart_id    = $request->session()->get($this->orderShoppingCartIdKey);
    	$order->coupon_total_value = $request->session()->get($this->couponTotalValueKey);
    	$order->total_price		   = $request->session()->get($this->orderTotalPriceKey);
    	$order->final_price 	   = $request->session()->get($this->orderFinalPriceKey);
    	
    	$order->save();

    	return $order;
    }

    /**
     * Update Order status based on the order reference number.
     *
     * @param  String $status           the order status
     * @param  String $referenceNumber  the order reference number
     * @return App/Order the Order instance
     */
    public function updateOrderStatus(Request $request, String $status, String $referenceNumber)
    {
        Log::info('Updating status of order with reference number: '.$referenceNumber);

        $order = App\Order::where('reference_number');

        $order->status = $status;
        $order->save();

        return $order;
    }

    /**
     * Update Order status to local file for support.
     * Delete old order details file.
     * Create new order details file.
     *
     * @param  App/Order $order     the Order instance containing all the order information
     * @return App/Order            the updated order
     */
    public function updateOrderFile($order) 
    {
        Log::info('Deleting old order details file for support team at '.storage_path('app/orders/').$order->reference_number.'.txt');   
        Storage::disk('local')->delete('orders/'.$order->reference_number.'.txt');

        $template = Storage::disk('local')->get('orders/order-template.txt');
        $template = str_replace('{{ id }}', $order->id, $template);
        $template = str_replace('{{ reference_number }}', $order->reference_number, $template);
        $template = str_replace('{{ status }}', $order->status, $template);
        $template = str_replace('{{ name }}', $order->name, $template);
        $template = str_replace('{{ email }}', $order->email, $template);
        $template = str_replace('{{ phone_number }}', $order->phone_number, $template);
        $template = str_replace('{{ address }}', $order->address, $template);
        $template = str_replace('{{ contents }}', $this->getCartContentString(), $template);
        $template = str_replace('{{ total_price }}', $order->address, $template);
        $template = str_replace('{{ coupon_total_value }}', $order->coupon_total_value, $template);
        $template = str_replace('{{ delivery_cost }}', $order->delivery_cost, $template);
        $template = str_replace('{{ final_price }}', $order->final_price, $template);

        Log::info('Storing new order details for support team at '.storage_path('app/orders/').$order->reference_number.'.txt');

        Storage::disk('local')->put('orders/'.$order->reference_number.'.txt', $template);
    }

    /**
     * Clear all Order related values stored in session.
     *
     * @param  Request $request
     * @return void
     */
    public function clearOrder(Request $request)
    {
    	Log::info('Clearing stored Order values in session');

        Cart::destroy();
        $request->session()->forget($this->orderNameKey);
        $request->session()->forget($this->orderEmailKey);
        $request->session()->forget($this->orderPhoneNumberKey);
        $request->session()->forget($this->orderAddressKey);
        $request->session()->forget($this->orderDeliveryCostKey);
        $request->session()->forget($this->orderShoppingCartIdKey);
        $request->session()->forget($this->orderReferenceNumberKey);
        $request->session()->forget($this->orderTotalPriceKey);
        $request->session()->forget($this->orderFinalPriceKey);
    }

    /**
     * Returns the dropdown options for State.
     *
     * @return array dropdown options for State
     */
    public function getStates()
    {
        $states = array_merge($this->westStates, $this->eastStates);
        sort($states);
        return $states;
    }

    /**
     * Return constructed address text.
     *
     * @param  Request $request
     * @return constructed address text
     */
    public function constructAddress(Request $request)
    {
        $number   = $request->number;
        $street   = $request->street;
        $city     = $request->city;
        $postcode = $request->postcode;
        $state    = $request->state;
        $country  = $request->country;

    	return $number.', '.$street.', '.$city.', '.$postcode.', '.$state.', '.$country;
    }

    /**
     * Returns the order reference number.
     * 
     * @return String order reference number
     */
    public function constructReferenceNumber()
    {
    	return 'OD'.str_random(8).Carbon::now()->timestamp;
    }

    /**
     * Checks whether the response signtaure is equivalent to the rawSignature.
     *
     * @param  String  $responseSignature 
     * @param  String  $rawSignature      
     * @return boolean whether the response signtaure is equivalent to the rawSignature
     */
    public function isValidSignature($responseSignature, $rawSignature)
    {
    	return $responseSignature == $this->getSignature($rawSignature);
    }

    /**
     * Checks whether the response amount is equal the order amount.
     *
     * @param  String $respAmount
     * @return boolean  whether the response amount is equal the order amount
     */
    public function isValidAmount(Request $request, $respAmount)
    {
        $deliveryCost     = $this->getDeliveryCost();
        $couponTotalValue = $this->getCouponTotalValue($request);
        // $finalPrice    = $this->getFinalPrice($couponTotalValue, $deliveryCost);
        $finalPrice       = '1.00';

        return $finalPrice == $respAmount;
    }

    /**
     * Returns the calculated delivery cost based on delivery weight and rate per kilo.
     *
     * @param Request $request
     * @return float calculated delivery cost
     */
    public function calculateDeliveryCost(Request $request) 
    {
        $totalWeight = $this->calculateTotalDeliveryWeight();
        $state = $request->state;
        $cost = 0.00;

        if (in_array($state, $this->eastStates))
        {
            $cost = $this->calculateEastDeliveryCost($totalWeight);
        } else if (in_array($state, $this->westStates))
        {
            $cost = $this->calculateWestDeliveryCost($totalWeight);
        }

        return number_format((float) $cost, 2, '.', '');
    }

    /**
     * Returns calculate total delivery weight of all items in cart.
     *
     * @return decimal calculate total delivery weight of all items in cart
     */
    public function calculateTotalDeliveryWeight()
    {
        $totalWeight = 0.00;
        foreach (Cart::content() as $row) {
            try {
                $weight = floatval($row->options['delivery_weight'])*floatval($row->qty);
                $totalWeight += $weight;
            } catch (\Exception $e) {
                $totalWeight += 0.00;
            }
        }

        Log::info('Total delivery weight: '.$totalWeight);

        return $totalWeight;
    }

    /**
     * Calculate the total delivery cost for east Malaysia based on weight.
     *
     * @param  Decimal $weight
     * @return Decimal total delivery cost for east Malaysia based on weight
     */
    public function calculateEastDeliveryCost($weight)
    {
        $rate = Configuration::shippingRateEastPerKilo()->first()->value;
        $minCharge = Configuration::shippingRateEastMinCharge()->first()->value;
        $minWeight = floatval(Configuration::shippingRateEastMinWeight()->first()->value);
        $totalWeight = floatval($weight);
        $cost = 0.00;

        Log::info('Calulating delivery cost for East Malaysia for weight: '.$totalWeight);
        Log::info('East Malaysia minimum charge: '.$minCharge);
        Log::info('East Malaysia minimum weight: '.$minWeight);
        Log::info('Total weight: '.$totalWeight);
        Log::info('Formula for East Malaysia: ((((($totalWeight-$minWeight)*1.5)+10)*1.35)*1.06)+5');

        if ($totalWeight < $minWeight)
        {
            $cost = $minCharge;
        } else
        {
            $cost = (((($totalWeight-$minWeight)*11)+55)*1.06)+5;            
        }

        return $cost;
    }

    /**
     * Calculate the total delivery cost for west Malaysia based on weight.
     *
     * @param  Decimal $weight
     * @return Decimal total delivery cost for west Malaysia based on weight
     */
    public function calculateWestDeliveryCost($weight)
    {
        $rate = Configuration::shippingRateWestPerKilo()->first()->value;
        $minCharge = Configuration::shippingRateWestMinCharge()->first()->value;
        $minWeight = floatval(Configuration::shippingRateWestMinWeight()->first()->value);
        $totalWeight = floatval($weight);
        $cost = 0.00;

        Log::info('Calulating delivery cost for West Malaysia for weight: '.$totalWeight);
        Log::info('West Malaysia minimum charge: '.$minCharge);
        Log::info('West Malaysia minimum weight: '.$minWeight);
        Log::info('Total weight: '.$totalWeight);
        Log::info('Formula for West Malaysia: (((($totalWeight-$minWeight)*1.7)+10.5)*1.06)+5');

        if ($totalWeight < $minWeight)
        {
            $cost = $minCharge;
        } else
        {
            // $cost = ((((($totalWeight-$minWeight)*1.5)+10)*1.35)*1.06)+10;
            $cost = (((($totalWeight-$minWeight)*1.7)+10.5)*1.06)+5;
        }

        return $cost;
    }

    /**
     * Return calculated final price from the coupon total value and delivery cost.
     *
     * @param  Request $request
     * @return float    calculated final price
     */
    public function calculateFinalPrice(Request $request)
    {
        $couponTotalValue = $request->session()->get($this->couponTotalValueKey);
        $deliveryCost = $request->session()->get($this->orderDeliveryCostKey);
        $finalPrice = floatval(Cart::total(2, '.', '')) + floatval($deliveryCost) - floatval($couponTotalValue);
        return $finalPrice < 0 ? 0.00 : number_format((float)$finalPrice, 2, '.', '');
    }

    /**
     * Generate signature for ipay88 request.
     *
     * @param  String $source 
     * @return signature
     */
    public function getSignature($source)
	{
       	return base64_encode(hex2bin(sha1($source)));
	}

    /**
     * Generate signature for ipay88 request.
     *
     * @param  String $hexSource
     * @return signature
     */
    public function hex2bin($hexSource)
    {
        for ($i=0;$i<strlen($hexSource);$i=$i+2)
        {
           $bin .= chr(hexdec(substr($hexSource,$i,2)));
        }
        return $bin;
    }
}