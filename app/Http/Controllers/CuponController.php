<?php

namespace App\Http\Controllers;

use App\Models\Cupon;
use Illuminate\Http\Request;

class CuponController extends Controller
{
    private $cupon, $cupons;

    public function index()
    {
        return view('admin.cupon.index');
    }

    public function create(Request $request)
    {
        Cupon::newCupon($request);
        return back()->with('message', 'Cupon info create successfully.');
    }

    public function manage()
    {
        $this->cupons = Cupon::all();
        return view('admin.cupon.manage', ['cupons' => $this->cupons]);
    }

    public function edit($id)
    {
        $this->cupon = Cupon::find($id);
        return view('admin.cupon.edit', ['cupon' => $this->cupon]);
    }

    public function update(Request $request, $id)
    {
        Cupon::updateCupon($request, $id);
        return redirect('/cupon/manage')->with('message', 'Cupon info update successfully.');
    }

    public function delete($id)
    {
        Cupon::deleteCupon($id);
        return back()->with('message', 'Cupon info delete successfully.');
    }
}
