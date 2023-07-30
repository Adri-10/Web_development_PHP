<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use PDF;

class AdminOrderController extends Controller
{
    private $pdf;

    public function index()
    {
        return view('admin.order.index', ['orders' => Order::orderBy('id', 'desc')->get()]);
    }

    public function detail($id)
    {
        return view('admin.order.detail', ['order' => Order::find($id)]);
    }

    public function edit($id)
    {
        return view('admin.order.edit',['order' => Order::find($id)]);
    }

    public function update(Request $request)
    {
        Order::updateOrderInfo($request);
        return redirect('/admin/manage-order')->with('message', 'Order status info update successfully.');
    }

    public function invoice($id)
    {
        return view('admin.order.invoice', ['order' => Order::find($id)]);
    }

    public function downloadInvoice($id)
    {
        $this->pdf = Pdf::loadView('admin.order.download-invoice', ['order' => Order::find($id)]);
        return $this->pdf->stream('invoice-00'.$id.'.pdf');
    }

    public function delete($id)
    {
        Order::deleteOrder($id);
        return redirect('/admin/manage-order')->with('message', 'Order status info delete successfully.');
    }
}
