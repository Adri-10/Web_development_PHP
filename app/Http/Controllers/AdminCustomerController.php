<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminCustomerController extends Controller
{
    public function index()
    {
        return view('admin.customer.index', ['customers' => Customer::orderBy('id', 'desc')->get()]);
    }
    public function detail($id)
    {
        return view('admin.customer.detail', ['customer' => Customer::find($id)]);
    }
    public function edit($id)
    {
        return view('admin.customer.edit', ['customer' => Customer::find($id)]);
    }
    public function update(Request $request)
    {
        Customer::updateCustomer($request);
        return redirect('/admin/manage-customer')->with('message', 'Order status info updated successfully');
    }
    public function download($id)
    {
        return view('admin.customer.download');
    }
    public function delete($id)
    {
        Customer::deleteCustomer($id);
        return redirect('/admin/manage-customer')->with('message', 'Order status info deleted successfully');

    }
}
