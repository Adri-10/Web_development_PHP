<?php

namespace App\Models;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use Session;

class Order extends Model
{
    use HasFactory;
    private static $order, $product;

    public static function newOrder($request, $customerId)
    {
        self::$order = new Order();
        self::$order->customer_id       = $customerId;
        self::$order->order_total       = Session::get('order_total');
        self::$order->tax_amount        = Session::get('tax_amount');
        self::$order->shipping_amount   = Session::get('shipping_amount');
        if (Session::get('cupon_amount'))
        {
            self::$order->discount_amount   = Session::get('cupon_amount');
            self::$order->cupon_name        = Session::get('cupon_name');
        }
        self::$order->order_date        = date('Y-m-d');
        self::$order->order_timestamp   = strtotime(date('Y-m-d'));
        self::$order->payment_type      = $request->payment_type;
        self::$order->delivery_address  = $request->delivery_address;
        self::$order->save();
        return self::$order;
    }

    public static function updateOrderInfo($request)
    {
        self::$order = Order::find($request->id);
        if ($request->order_status == 'Pending')
        {
            return back();
        }
        else if ($request->order_status == 'Processing')
        {
            self::$order->delivery_address  = $request->delivery_address;
            self::$order->order_status      = $request->order_status;
            self::$order->payment_status    = $request->order_status;
            self::$order->delivery_status   = $request->order_status;
            self::$order->save();
        }
        else if ($request->order_status == 'Complete')
        {
            self::$order->order_status      = $request->order_status;
            self::$order->payment_status    = $request->order_status;
            self::$order->delivery_status   = $request->order_status;
            self::$order->save();

            foreach (self::$order->orderDetails as $orderDetail)
            {
                self::$product = Product::find($orderDetail->product_id);
                self::$product->stock_amount = self::$product->stock_amount - $orderDetail->product_qty;
                self::$product->save();
            }
        }
        else if ($request->order_status == 'Cancel')
        {
            self::$order->order_status      = $request->order_status;
            self::$order->payment_status    = $request->order_status;
            self::$order->delivery_status   = $request->order_status;
            self::$order->save();
        }

    }

    public static function deleteOrder($id)
    {
        self::$order = Order::find($id);
        foreach (self::$order->orderDetails as $orderDetail)
        {
            $orderDetail->delete();
        }


        self::$order->delete();
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class,'customer_id', 'id');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
