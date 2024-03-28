<?php

namespace App\Http\Controllers;

use App\Models\Vehiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VehiculoController extends Controller
{
  public function index()
  {
    $vehiculos = Vehiculo::all();
    return view('vehiculos.index', compact("vehiculos"));
  }

  public function store(Request $request)
  {
    try {
      $request->validate(
        [
          'placa' => 'required',
          'marca' => 'required',
          'modelo' => 'required',
          'categoria_m1_l' => 'required',
        ]
      );

      $data = $request->all();
      $data['user_id'] = Auth::id();

      Vehiculo::create($data);

      return response()->json([
        'message' => 'Vehiculo creado correctamente'
      ], 201);
    } catch (\Throwable $th) {
      return response()->json([
        'message' => $th->getMessage()
      ], 500);
    }
  }

  public function update(Request $request, Vehiculo $vehiculo)
  {
    try {
      $request->validate(
        [
          'placa' => 'required|string|max:11',
          'marca' => 'required',
          'modelo' => 'required',
          'categoria_m1_l' => 'required',
        ]
      );

      $vehiculo->update($request->all());

      return response()->json([
        'message' => 'Vehiculo actualizado correctamente'
      ], 200);
    } catch (\Throwable $th) {
      return response()->json([
        'message' => $th->getMessage()
      ], 500);
    }
  }

  public function destroy(Vehiculo $vehiculo)
  {
    try {
      $vehiculo->delete();

      return response()->json([
        'message' => 'Vehiculo eliminado correctamente'
      ], 200);
    } catch (\Throwable $th) {
      return response()->json([
        'message' => $th->getMessage()
      ], 500);
    }
  }
}
