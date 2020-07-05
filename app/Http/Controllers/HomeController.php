<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Customer;

class HomeController extends Controller
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
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if ( auth()->user()->id != 1 ){
            return redirect('/')->with('success', 'Welcome Customer!');
        }

        $customers = Customer::all();

        return view('home')->with( 'customers', $customers );
    }

    /**
     * Show the application dashboard.
     *
     * @param int $id user_id of customer
     * @return void
     */
    public function deleteCustomer($id)
    {

        $customer = Customer::where('user_id', $id)->delete();

        return redirect('/home')->with('success', 'Removed customer information');
    }
}
