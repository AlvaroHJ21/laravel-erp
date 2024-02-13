<?php

namespace App\Http\Controllers;

use App\Models\Entidad;
use App\Models\TipoDocumentoIdentidad;
use Illuminate\Http\Request;

class EntidadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $entidades = Entidad::all();
        return view("entidades.index", compact("entidades"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tiposDocumentosIdentidad = TipoDocumentoIdentidad::all();
        return view("entidades.create", compact("tiposDocumentosIdentidad"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'tipo_documento_id' => 'required|numeric',
            'numero_documento' => 'required|string',
            'direccion' => 'required|string',
            'tipo' => 'required|numeric',
            'telefono' => 'required|string',
            'correo' => 'required|string',
            'porcentaje_descuento' => 'nullable|numeric',
            'retencion' => 'nullable|numeric',
            'ubigeo' => 'required|string|size:6',
        ]);

        Entidad::create($request->all());

        return redirect()->route("entidades.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(Entidad $entidad)
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Entidad $entidad)
    {
        $tiposDocumentosIdentidad = TipoDocumentoIdentidad::all();
        return view("entidades.edit", compact("entidad", "tiposDocumentosIdentidad"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Entidad $entidad)
    {
        $request->validate([
            'nombre' => 'required|string',
            'tipo_documento_id' => 'required|numeric',
            'numero_documento' => 'required|string',
            'direccion' => 'required|string',
            'tipo' => 'required|numeric',
            'telefono' => 'required|string',
            'correo' => 'required|string',
            'porcentaje_descuento' => 'nullable|numeric',
            'retencion' => 'nullable|numeric',
            'ubigeo' => 'required|string|size:6',
        ]);

        $entidad->update($request->all());

        return redirect()->route("entidades.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Entidad $entidad)
    {
        $entidad->delete();
        return response()->noContent();
    }
}
