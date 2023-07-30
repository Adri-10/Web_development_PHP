<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    private static $brand, $image, $imageURL, $imageExtension, $imageName, $directory;

    public static function getImageUrl($request)
    {
        self::$image = $request->file('image');
        self::$imageExtension = self::$image->getClientOriginalExtension();
        self::$imageName = time().'.'.self::$imageExtension;
        self::$directory = 'brand-images/';
        self::$image->move(self::$directory, self::$imageName);
        self::$imageURL = self::$directory.self::$imageName;
        return self::$imageURL;
    }

    public static function newBrand($request)
    {
        self::$brand = new Brand();
        self::$brand->name           = $request->name;
        self::$brand->description    = $request->description;
        self::$brand->image          = self::getImageUrl($request);
        self::$brand->save();
    }

    public static function updateBrand($request, $id)
    {
        self::$brand = Brand::find($id);
        if ($request->file('image'))
        {
            if (file_exists(self::$brand->image))
            {
                unlink(self::$brand->image);
            }
            self::$imageURL = self::getImageUrl($request);
        }
        else
        {
            self::$imageURL = self::$brand->image;
        }
        self::$brand->name           = $request->name;
        self::$brand->description    = $request->description;
        self::$brand->image          = self::$imageURL;
        self::$brand->save();
    }

    public static function deleteBrand($id)
    {
        self::$brand = Brand::find($id);
        if (file_exists(self::$brand->image))
        {
            unlink(self::$brand->image);
        }
        self::$brand->delete();
    }
}
