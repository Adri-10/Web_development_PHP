<?php

namespace App\Http\Controllers;

use App\Models\Cupon;
use App\Models\Product;
use Illuminate\Http\Request;
use ShoppingCart;
use Session;

class CartController extends Controller
{
    private $product, $cartProduct, $cupon;

    public function addToCart(Request $request, $id)
    {
        $this->product = Product::find($id);
        ShoppingCart::add($this->product->id, $this->product->name, $request->qty, $this->product->selling_price, ['image' => $this->product->image, 'category_name' => $this->product->category->name, 'brand_name' => $this->product->brand->name]);
        return redirect('/show-cart');
    }

    public function show()
    {
        //return ShoppingCart::all();
        return view('website.cart.index', ['cart_products' => ShoppingCart::all()]);
    }

    public function remove($id)
    {
        ShoppingCart::remove($id);
        return back()->with('message', 'Cart item info remove successfully.');
    }

    public function update(Request $request, $id)
    {
        $this->cartProduct = ShoppingCart::get($id);
        $this->product = Product::find($this->cartProduct->id);
        if ($this->product->stock_amount >= $request->qty)
        {
            ShoppingCart::update($id, $request->qty);
            return back()->with('message', 'Cart item info update successfully.');
        }
        return back()->with('message', 'Sorry....maximim update amount is '.$this->product->stock_amount);
    }

    public function applyCupon(Request $request)
    {
        $this->cupon = Cupon::where('name', $request->coupon)->first();
        if ($this->cupon)
        {
            if ($this->cupon->status == 1)
            {
                return back()->with('message', 'Cupon already used.');
            }

            $sum = 0;
            foreach (ShoppingCart::all() as $item)
            {
                $sum = $sum + $item->total;
            }
            $tax = round(($sum * 0.15));
            $shipping = 500;
            $totalBill = $sum + $tax + $shipping;

            if ($totalBill >= $this->cupon->minimum_purchase_amount)
            {
                $this->cupon->status = 1;
                $this->cupon->save();

                Session::put('cupon_amount', $this->cupon->amount);
                Session::put('cupon_name', $this->cupon->name);
                return back()->with('message', 'Cupon apply successfully.');
            }
            return back()->with('message', 'For cupon apply, you should minimum purchase '. $this->cupon->minimum_purchase_amount);
        }
        return back()->with('message', 'Cupon code is wrong.');
    }
}
