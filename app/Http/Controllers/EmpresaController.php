<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmpresaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $empresas = Empresa::all();
        return view('empresas.index', compact('empresas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("empresas.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'ruc' => 'required|string|size:11',
            'razon_social' => 'required|string',
            'nombre_comercial' => 'required|string',
            'domicilio_fiscal' => 'required|string',
            'ubigeo' => 'required|string|size:6',
            'urbanizacion' => 'required|string|max:100',
            'distrito' => 'required|string|max:20',
            'provincia' => 'required|string|max:20',
            'departamento' => 'required|string|max:20',
            'telefono_fijo' => 'required|string|max:20',
            'telefono_movil' => 'required|string|max:10',
            'correo' => 'required|email|max:150',
            'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'codigo_sucursal_sunat' => 'nullable|string|max:10',
            'usu_secundario_usuario' => 'nullable|string|max:150',
            'usu_secundario_password' => 'nullable|string|max:150',
            'guias_client_id' => 'nullable|string|max:60',
            'guias_client_secret' => 'nullable|string|max:50',
            'access_token' => 'nullable|string',
        ]);

        $data = $request->all();

        if ($request->hasFile('logo')) {
            $url = $request->file('logo')->store('empresas/', 'public');
            $data = $request->except("logo");
            $data["logo"] = basename($url);
        }

        Empresa::create($data);

        return redirect()->route('empresas.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Empresa $empresa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Empresa $empresa)
    {
        return view('empresas.edit', compact('empresa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Empresa $empresa)
    {

        $request->validate([
            'ruc' => 'nullable|string|size:11',
            'razon_social' => 'nullable|string',
            'nombre_comercial' => 'nullable|string',
            'domicilio_fiscal' => 'nullable|string',
            'ubigeo' => 'nullable|string|size:6',
            'urbanizacion' => 'nullable|string|max:100',
            'distrito' => 'nullable|string|max:20',
            'provincia' => 'nullable|string|max:20',
            'departamento' => 'nullable|string|max:20',
            'telefono_fijo' => 'nullable|string|max:20',
            'telefono_movil' => 'nullable|string|max:10',
            'correo' => 'nullable|email|max:150',
            'logo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'codigo_sucursal_sunat' => 'nullable|string|max:10',
            'usu_secundario_usuario' => 'nullable|string|max:150',
            'usu_secundario_password' => 'nullable|string|max:150',
            'guias_client_id' => 'nullable|string|max:60',
            'guias_client_secret' => 'nullable|string|max:50',
            'access_token' => 'nullable|string',
        ]);

        $data = $request->all();

        if ($request->hasFile('logo')) {
            $oldImage = $empresa->logo;
            Storage::disk('public')->delete("empresas/$oldImage");

            $url = $request->file('logo')->store('empresas/', 'public');
            $data = $request->except("logo");
            $data["logo"] = basename($url);
        }

        // dd($data);

        $empresa->update($data);

        return redirect()->route('empresas.index');
    }

    public function toggleMode(Empresa $empresa)
    {
        $empresa->update([
            'modo' => !$empresa->modo
        ]);

        return redirect()->route('empresas.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Empresa $empresa)
    {
        $empresa->delete();

        Storage::disk('public')->delete("empresas/$empresa->logo");

        return response()->noContent();
    }
}
