<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class APIController extends Controller
{
    private $categories, $products, $product;

    public function getAllCategoryInfo()
    {
        $this->categories = Category::all();
        foreach ($this->categories as $category)
        {
            $category->sub_categories = $category->subCategories;
        }
        return response()->json($this->categories);
    }

    public function getTrendingProduct()
    {
        $this->products = Product::orderBy('id', 'desc')->take(8)->get(['id', 'category_id', 'name', 'image', 'selling_price']);
        foreach ($this->products as $product)
        {
            $product->image          = asset($product->image);
            $product->category_name  = $product->category->name;
        }
        return response()->json($this->products);
    }

    public function getCategoryProduct($id)
    {
        $this->products = Product::where('category_id', $id)->orderBy('id', 'desc')->take(9)->get(['id', 'category_id', 'name', 'image', 'selling_price']);
        foreach ($this->products as $product)
        {
            $product->image          = asset($product->image);
            $product->category_name  = $product->category->name;
        }
        return response()->json($this->products);
    }

    public function getProductInfo($id)
    {
        $this->product = Product::find($id);
        $this->product->image = asset($this->product->image);
        $this->product->category_name = $this->product->category->name;
        $this->product->sub_category_name = $this->product->subCategory->name;
        $this->product->brand_name = $this->product->brand->name;
        $this->product->other_images = $this->product->otherImages;
        foreach ($this->product->other_images as $other_image)
        {
            $other_image->image = asset($other_image->image);
        }
        return response()->json($this->product);
    }
}
