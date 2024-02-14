<?php

namespace App\Http\Controllers;

use App\Models\TipoIgv;
use Illuminate\Http\Request;

class TipoIgvController extends Controller
{
    public function index()
    {
        $tipos = TipoIgv::all();
        return view('almacen.tipos_igv', compact('tipos'));
    }

    public function toggleActive(TipoIgv $tipo)
    {
        $tipo->activo = !$tipo->activo;
        $tipo->save();

        return redirect()->route('tipos_igv.index');
    }
}
