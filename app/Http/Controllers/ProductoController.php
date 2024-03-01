<?php

namespace App\Http\Controllers;

use App\Models\Almacen;
use App\Models\Categoria;
use App\Models\Inventario;
use App\Models\Producto;
use App\Models\TipoIgv;
use App\Models\Unidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
  public function index()
  {
    $productos = Producto::all();
    return view("productos.index", compact("productos"));
  }

  public function create()
  {
    $unidades = Unidad::all();
    $categorias = Categoria::all();
    $tiposIgv = TipoIgv::all();
    return view("productos.create", compact("unidades", "categorias", "tiposIgv"));
  }

  public function store(Request $request)
  {
    $request->validate([
      "codigo" => "required|string",
      "nombre" => "required|string",
      "precio_compra" => "required|numeric",
      "precio_venta" => "required|numeric",
      "valor_venta" => "nullable|numeric",
      "imagen" => "nullable|image",
      "categoria_id" => "required",
      "unidad_id" => "required",
      "moneda_id" => "required",
      "tipo_igv_id" => "required",
      "stock_inicial" => "required|numeric",
    ]);

    $data = $request->all();

    if ($request->hasFile('imagen')) {
      $url = $request->file('imagen')->store('productos/', 'public');
      $data = $request->except("imagen");
      $data["imagen"] = basename($url);
    }

    $data["user_id"] = auth()->id();

    $producto = Producto::create($data);

    //si existe un almacén, se crea un inventario con stock 0
    if (Almacen::count() > 0) {
      Inventario::create([
        "producto_id" => $producto->id,
        "almacen_id" => Almacen::latest()->first()->id,
        "cantidad" => $request->stock_inicial,
      ]);
    }

    return redirect()->route("productos.index");
  }

  public function edit(Producto $producto)
  {
    $unidades = Unidad::all();
    $categorias = Categoria::all();
    $tiposIgv = TipoIgv::all();
    return view("productos.edit", compact("producto", "unidades", "categorias", "tiposIgv"));
  }

  public function update(Request $request, Producto $producto)
  {
    $request->validate([
      "codigo" => "string",
      "nombre" => "string",
      "precio_compra" => "numeric",
      "precio_venta" => "numeric",
      "valor_venta" => "nullable|numeric",
      "imagen" => "nullable|image",
      "categoria_id" => "",
      "unidad_id" => "",
      "moneda_id" => "",
      "tipo_igv_id" => "",
    ]);

    $data = $request->all();

    if ($request->hasFile("imagen")) {

      if ($producto->imagen) {
        Storage::disk('public')->delete("productos/$producto->imagen");
      }

      $url = $request->file('imagen')->store('productos/', 'public');
      $data = $request->except("imagen");
      $data["imagen"] = basename($url);
    }

    $producto->update($data);

    return redirect()->route("productos.index");
  }

  public function destroy(Producto $producto)
  {
    if ($producto->imagen) {
      Storage::disk('public')->delete("productos/$producto->imagen");
    }
    $producto->delete();
    return response()->noContent();
  }
}
