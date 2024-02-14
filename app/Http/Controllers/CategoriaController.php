<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        $categorias = Categoria::all();
        return view('almacen.categorias', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|max:8',
            'nombre' => 'required|max:100'
        ]);

        Categoria::create($request->all());

        return redirect()->route('categorias.index');
    }

    public function update(Request $request, Categoria $categoria)
    {
        $request->validate([
            'codigo' => 'required|max:8',
            'nombre' => 'required|max:100'
        ]);

        $categoria->update($request->all());

        return redirect()->route('categorias.index');
    }

    public function toggleActive(Categoria $categoria)
    {
        $categoria->activo = !$categoria->activo;
        $categoria->save();

        return redirect()->route('categorias.index');
    }
}
