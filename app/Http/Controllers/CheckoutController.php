<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetail;
use Illuminate\Http\Request;
use ShoppingCart;
use Session;

class CheckoutController extends Controller
{
    private $order, $orderDetail, $customer;

    public function index()
    {
        if (Session::get('customer_id'))
        {
            $this->customer = Customer::find(Session::get('customer_id'));
        }
        else
        {
            $this->customer = '';
        }

        return view('website.checkout.index', ['cart_products' => ShoppingCart::all(), 'customer' => $this->customer]);
    }

    public function newOrder(Request $request)
    {
        if(Session::get('customer_id'))
        {
            $this->customer = Customer::find(Session::get('customer_id'));
        }
        else
        {
            $this->validate($request, [
                'name'      => 'required',
                'email'     => 'required|unique:customers,email',
                'mobile'    => 'required|unique:customers,mobile',
                'delivery_address'   => 'required',
            ], [
                'name.required' => 'Vai please name ta den',
                'email.required' => 'Vai please email ta den',
                'email.unique' => 'Vai eta already ase',
            ]);

            $this->customer = Customer::newCustomer($request);
            Session::put('customer_id', $this->customer->id);
            Session::put('customer_name', $this->customer->name);
        }
        if($request->payment_type == 1)
        {
            $this->order = Order::newOrder($request, $this->customer->id);
            OrderDetail::newOrderDetail($this->order->id);
            return redirect('/complete-order');
        }
        else
        {
            return view('website.checkout.exampleHosted',[
                'customer'      => $this->customer,
                'address'       => $request->delivery_address,
                'cart_products' => ShoppingCart::all()
            ]);
        }

    }

    public function completeOrder()
    {
        return view('website.checkout.complete-order');
    }
}
