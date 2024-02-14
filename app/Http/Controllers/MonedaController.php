<?php

namespace App\Http\Controllers;

use App\Models\Moneda;
use Illuminate\Http\Request;

class MonedaController extends Controller
{
    public function index()
    {
        $monedas = Moneda::all();
        return view("configuracion.monedas", compact("monedas"));
    }

    public function changeStatus(Moneda $moneda)
    {
        $moneda->update([
            "activo" => !$moneda->activo
        ]);
        return redirect()->route("monedas.index");
    }
}
