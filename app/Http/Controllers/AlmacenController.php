<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use Illuminate\Http\Request;

class AlmacenController extends Controller
{
    public function index()
    {
        $almacenes = Almacen::all();
        return view('almacen.almacenes', compact('almacenes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:100'
        ]);

        $request->merge(['user_id' => auth()->id()]);

        Almacen::create($request->all());

        return redirect()->route('almacenes.index');
    }

    public function update(Request $request, Almacen $almacen)
    {
        $request->validate([
            'nombre' => 'required|max:100'
        ]);

        $almacen->update($request->all());

        return redirect()->route('almacenes.index');
    }

    public function toggleActive(Almacen $almacen)
    {
        $almacen->activo = !$almacen->activo;
        $almacen->save();

        return redirect()->route('almacenes.index');
    }
}
