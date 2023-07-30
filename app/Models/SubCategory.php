<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    use HasFactory;
    private static $subCategory, $image, $imageURL, $imageExtension, $imageName, $directory;

    public static function getImageUrl($request)
    {
        self::$image            = $request->file('image');
        self::$imageExtension   = self::$image->getClientOriginalExtension();
        self::$imageName        = time().'.'.self::$imageExtension;
        self::$directory        = 'sub-category-images/';
        self::$image->move(self::$directory, self::$imageName);
        self::$imageURL         = self::$directory.self::$imageName;
        return self::$imageURL;
    }

    public static function newSubCategory($request)
    {
        self::$subCategory = new SubCategory();
        self::$subCategory->category_id     = $request->category_id;
        self::$subCategory->name            = $request->name;
        self::$subCategory->description     = $request->description;
        self::$subCategory->image           = self::getImageUrl($request);
        self::$subCategory->save();
    }

    public static function updateSubCategory($request, $id)
    {
        self::$subCategory = SubCategory::find($id);
        if ($request->file('image'))
        {
            if (file_exists(self::$subCategory->image))
            {
                unlink(self::$subCategory->image);
            }
            self::$imageURL = self::getImageUrl($request);
        }
        else
        {
            self::$imageURL = self::$subCategory->image;
        }
        self::$subCategory->category_id     = $request->category_id;
        self::$subCategory->name            = $request->name;
        self::$subCategory->description     = $request->description;
        self::$subCategory->image           = self::$imageURL;
        self::$subCategory->save();
    }

    public static function deleteSubCategory($id)
    {
        self::$subCategory = SubCategory::find($id);
        if (file_exists(self::$subCategory->image))
        {
            unlink(self::$subCategory->image);
        }
        self::$subCategory->delete();
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
