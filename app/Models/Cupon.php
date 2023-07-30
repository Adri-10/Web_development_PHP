<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cupon extends Model
{
    use HasFactory;

    private static $cupon;


    public static function newCupon($request)
    {
        self::$cupon = new Cupon();
        self::$cupon->name                      = $request->name;
        self::$cupon->amount                    = $request->amount;
        self::$cupon->minimum_purchase_amount   = $request->minimum_purchase_amount	;
        self::$cupon->save();
    }

    public static function updateCupon($request, $id)
    {
        self::$cupon = Cupon::find($id);
        self::$cupon->name                      = $request->name;
        self::$cupon->amount                    = $request->amount;
        self::$cupon->minimum_purchase_amount   = $request->minimum_purchase_amount	;
        self::$cupon->save();
    }

    public static function deleteCupon($id)
    {
        self::$cupon = Cupon::find($id);
        self::$cupon->delete();
    }
}
