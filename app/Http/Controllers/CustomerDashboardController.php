<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use Cassandra\Custom;
use Illuminate\Http\Request;
use Session;

class CustomerDashboardController extends Controller
{
    public function index()
    {
        return view('website.customer.index');
    }

    public function profile()
    {
        //return Customer::find(Session::get('customer_id'));

        return view('website.customer.profile', ['customer' => Customer::find(Session::get('customer_id'))]);
    }

    public function updateProfile(Request $request)
    {
        Customer::updateCustomer($request);
        return back()->with('message', 'Profile info update successfully.');
    }

    public function order()
    {
        return view('website.customer.order', ['orders' => Order::where('customer_id', Session::get('customer_id'))->get()]);
    }

    public function changePassword()
    {
        return view('website.customer.change-password');
    }


}
