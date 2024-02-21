<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use App\Models\Inventario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AlmacenController extends Controller
{
    public function index()
    {
        $almacenes = Almacen::all();
        $inventarioACD = Inventario::with(
            'producto',
            'almacen'
        )->get()->map(function ($inventario) {
            $data["value"] = $inventario->id;
            $data["text"] = $inventario->producto->nombre . ' - ' . $inventario->almacen->nombre . ' - ' . $inventario->cantidad;
            $data["filter"] = $inventario->almacen->id;
            $data["meta"] = $inventario->cantidad;
            return $data;
        });
        return view('almacen.almacenes', compact('almacenes', 'inventarioACD'));
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

    public function move(Request $request)
    {

        $validator = Validator::make(
            $request->all(),
            [
                'almacen_origen_id' => 'required|exists:almacenes,id',
                'almacen_destino_id' => 'required|exists:almacenes,id',
                'inventario_id' => 'required|exists:inventarios,id',
                'cantidad' => 'required|numeric|min:1'
            ]
        );

        // Validamos que el almacen origen y destino sean diferentes
        if ($request->almacen_origen_id == $request->almacen_destino_id) {
            $validator->errors()->add('almacen_destino_id', 'El almacen origen y destino deben ser diferentes');

            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Buscamos si en el inventario tiene la cantidad suficiente
        $inventario = Inventario::find($request->inventario_id);

        if ($inventario->cantidad < $request->cantidad) {
            $validator->errors()->add('cantidad', 'No hay suficiente cantidad en el inventario');

            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Restamos la cantidad del inventario origen
        // si al restar lo solicitado es igual a 0, eliminamos el registro
        // if ($inventario->cantidad - $request->cantidad == 0) {
        //     $inventario->delete();
        // } else {
        $inventario->decrement('cantidad', $request->cantidad);
        // }

        // Buscamos si ya existe un inventario con el almacen de destino y el producto del inventario
        $inventarioDestino = Inventario::where('almacen_id', $request->almacen_destino_id)
            ->where('producto_id', $inventario->producto_id)
            ->first();

        // Si existe, sumamos la cantidad
        if ($inventarioDestino) {
            $inventarioDestino->increment('cantidad', $request->cantidad);
        } else {
            // Si no existe, creamos un nuevo registro
            Inventario::create([
                'almacen_id' => $request->almacen_destino_id,
                'producto_id' => $inventario->producto_id,
                'cantidad' => $request->cantidad
            ]);
        }

        return redirect()->route('almacenes.index');
    }
}
