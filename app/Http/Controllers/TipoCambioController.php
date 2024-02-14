<?php

namespace App\Http\Controllers;

use App\Models\TipoCambio;
use Illuminate\Http\Request;

class TipoCambioController extends Controller
{
    public function index()
    {
        $tipos = TipoCambio::all();

        //TODO: Obtener el tipo de cambio de hoy
        $tipoCambioCompraHoy = 3.7;
        $tipoCambioVentaHoy = 3.6;
        return view('configuracion.tipos_cambio', compact("tipos", "tipoCambioCompraHoy", "tipoCambioVentaHoy"));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipo_cambio_compra' => 'required',
            'tipo_cambio_venta' => 'required',
            'proveniente' => 'required',
        ]);

        $request->merge([
            'moneda_id' => 1,
        ]);

        TipoCambio::create($request->all());

        return redirect()->route('tipos_cambio.index')
            ->with('success', 'Tipo de cambio creado exitosamente.');
    }
}
