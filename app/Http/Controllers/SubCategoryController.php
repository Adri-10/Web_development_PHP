<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    private $categories, $subCategory, $subCategoris;

    public function index()
    {
        $this->categories = Category::all();
        return view('admin.sub-category.index', ['categories' => $this->categories]);
    }

    public function create(Request $request)
    {
        SubCategory::newSubCategory($request);
        return back()->with('message', 'Sub category info create successfully.');
    }

    public function manage()
    {
        $this->subCategoris = SubCategory::all();
        return view('admin.sub-category.manage', ['sub_categories' => $this->subCategoris]);
    }

    public function edit($id)
    {
        $this->subCategory  = SubCategory::find($id);
        $this->categories   = Category::all();
        return view('admin.sub-category.edit', [
            'sub_category'  => $this->subCategory,
            'categories'    => $this->categories,
        ]);
    }

    public function update(Request $request, $id)
    {
        SubCategory::updateSubCategory($request, $id);
        return redirect('/sub-category/manage')->with('message', 'Sub category info update successfully.');
    }

    public function delete($id)
    {
        SubCategory::deleteSubCategory($id);
        return back()->with('message', 'Sub category info delete successfully.');
    }

}
