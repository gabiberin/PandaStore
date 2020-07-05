<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;

use App\Product;
use App\Customer;
use App\Country;
use App\Order;
use App\OrderItem;

class CheckoutController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user_id = auth()->user()->id;

        if (Cart::count() == 0) {
            return redirect('/');
        }

        if ( ! $this->checkProducts() ) {
            return redirect('/cart')->with('error', 'Some of the items in your cart are no longer available.');
        }

        $countries = Country::all();
        $page_options = array(
            'countries' => $countries,
        );

        $customer = Customer::where(['user_id' => $user_id])->first();
        if ( $customer ) {
            $page_options['customer'] = $customer;
        }

        return view('checkout.page')->with($page_options);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Cart::count() == 0) {
            return redirect('/');
        }

        if ( ! $this->checkProducts() ) {
            return redirect('/cart')->with('error', 'Some of the items in your cart are no longer available.');
        }

        $user_id = auth()->user()->id;

        $customer = Customer::where(['user_id' => $user_id])->first();
        if ( ! isset($customer) ) {
            $customer = new Customer;
            $customer->user_id = $user_id;
        }

        $customer->shipping_first_name = $request->input('shipping_first_name');
        $customer->shipping_last_name = $request->input('shipping_last_name');
        $customer->shipping_address = $request->input('shipping_address');
        $customer->shipping_city = $request->input('shipping_city');
        $customer->shipping_state = $request->input('shipping_state');
        $customer->shipping_postal_code = $request->input('shipping_postal_code');

        $country = Country::where('code', $request->input('shipping_country'))->first();
        if ( ! isset($country) ) {
            return redirect('/checkout')->with('error', 'Invalid country selected.');
        }

        $customer->country_code = $country->code;

        $customer->save();

        $order = new Order;
        $order->user_id = $user_id;
        $order->amount = Cart::total();

        $order->save();

        foreach ( Cart::content() as $item ) {
            $orderItem = new OrderItem;
            $orderItem->order_id = $order->id;
            $orderItem->product_id = $item->model->id;
            $orderItem->price = $item->subtotal;

            $orderItem->save();
        }

        Cart::destroy();

        return redirect('/')->with('success', 'Order Received!');
    }

    protected function checkProducts()
    {
        foreach ( Cart::content() as $item ) {

            if ( ! $item->model ) {
                Cart::destroy($item->rowId);
            }

            $product = Product::find($item->model->id);
            if ( ! isset($product) ) {
                return false;
            }

        }

        return true;
    }
}
