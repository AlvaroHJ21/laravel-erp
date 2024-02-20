<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    public function index()
    {
        $inventarios = Inventario::all();
        return view('almacen.inventarios', compact('inventarios'));
    }

    public function traslate(Request $request)
    {
        $request->validate([
            'almacen_origen_id' => 'required',
            'almacen_destino_id' => 'required',
            'producto_id' => 'required',
            'cantidad' => 'required'
        ]);


        dd($request->all());
    }
}
