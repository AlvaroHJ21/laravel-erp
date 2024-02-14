<?php

namespace App\Http\Controllers;

use App\Models\Unidad;
use Illuminate\Http\Request;

class UnidadController extends Controller
{
    public function index()
    {
        $unidades = Unidad::all();
        return view('almacen.unidades', compact("unidades"));
    }

    public function toggleActive(Unidad $unidad)
    {
        $unidad->activo = !$unidad->activo;
        $unidad->save();
        return redirect()->route('unidades.index');
    }
}
