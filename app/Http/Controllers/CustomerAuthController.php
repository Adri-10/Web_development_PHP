<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Session;


class CustomerAuthController extends Controller
{
    private $customer;

    public function index()
    {
        return view('website.customer.login');
    }

    public function login(Request $request)
    {
        $this->customer = Customer::where('email', $request->email)->first();
        if ($this->customer)
        {
            if (password_verify($request->password, $this->customer->password))
            {
                Session::put('customer_id', $this->customer->id);
                Session::put('customer_name', $this->customer->name);

                return redirect('/customer-dashboard');
            }
            else
            {
                return back()->with('message', 'Password does not match.');
            }
        }
        else
        {
            return back()->with('message', 'Email does not match.');
        }
    }

    public function register()
    {
        return view('website.customer.register');
    }


    public function newCustomer(Request $request)
    {
        $this->customer = Customer::newCustomer($request);
        Session::put('customer_id', $this->customer->id);
        Session::put('customer_name', $this->customer->name);
        return redirect('/customer-dashboard');
    }

    public function logout()
    {
        Session::forget('customer_id');
        Session::forget('customer_name');

        return redirect('/');
    }
}
