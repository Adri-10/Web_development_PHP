<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class EcommerceController extends Controller
{
    private $caetgories, $products;

    public function index()
    {
        $this->products = Product::orderBy('id', 'desc')->take(8)->get(['id', 'name', 'category_id', 'selling_price', 'image']);
        return view('website.home.index', ['products' => $this->products]);
    }

    public function category($id)
    {
        $this->products = Product::where('category_id', $id)->orderBy('id', 'desc')->get(['id', 'name', 'category_id', 'selling_price', 'image']);
        return view('website.category.index', ['products' => $this->products]);
    }

    public function detail($id)
    {
        return view('website.detail.index', ['product' => Product::find($id)]);
    }
}
