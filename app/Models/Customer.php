<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Session;
use App\Models\Order;

class Customer extends Model
{
    use HasFactory;

    private static $customer, $image, $imageURL, $imageExtension, $imageName, $directory;

    public static function getImageUrl($request)
    {
        self::$image = $request->file('image');
        if (self::$image) {
            self::$imageExtension = self::$image->getClientOriginalExtension();
            self::$imageName = time() . '.' . self::$imageExtension;
            self::$directory = 'customer-images/';
            self::$image->move(self::$directory, self::$imageName);
            self::$imageURL = self::$directory . self::$imageName;
            return self::$imageURL;
        }
    }


    public static function newCustomer($request)
    {
        self::$customer = new Customer();
        self::$customer->name = $request->name;
        self::$customer->email = $request->email;
        if ($request->password) {
            self::$customer->password = bcrypt($request->password);
        } else {
            self::$customer->password = bcrypt($request->mobile);
        }
        self::$customer->mobile = $request->mobile;
        self::$customer->save();
        return self::$customer;
    }

    public static function updateCustomer($request)
    {
        //self::$customer = Customer::find($id);
        self::$customer = Customer::find(Session::get('customer_id'));
        if ($request->file('image')) {
            if (file_exists(self::$customer->image)) {
                unlink(self::$customer->image);
            }
            self::$imageURL = self::getImageUrl($request);
        } else {
            if (self::$customer->image) {
                self::$imageURL = self::$customer->image;
            } else {
                self::$imageURL = 'download/avater.png';
            }
        }
        self::$customer->name = $request->name;
        self::$customer->email = $request->email;
        self::$customer->mobile = $request->mobile;
        self::$customer->nid = $request->nid;
        self::$customer->image = self::$imageURL;
        self::$customer->address = $request->address;
        self::$customer->date_of_birth = $request->date_of_birth;
        self::$customer->blood_group = $request->blood_group;
        self::$customer->save();
    }

//    public static function updateCustomerInfo($request)
//    {
//        self::$customer = Customer::find($request->id);
//        self::$customer->save();
//    }


    public static function deleteCustomer($id)
    {
        self::$customer = Customer::find($id);
        self::$customer->delete();
    }

    public function order()
    {
        return $this->hasMany(Order::class);
    }
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

}
