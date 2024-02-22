<?php

namespace App\Http\Controllers;

use App\Models\Moneda;
use App\Models\Unidad;
use App\Models\TipoIgv;
use App\Models\Cotizacion;
use App\Models\Entidad;
use App\Models\Producto;
use App\Models\TipoCambio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TipoDocumentoIdentidad;
use Illuminate\Support\Facades\Validator;

class CotizacionController extends Controller
{
  public function index()
  {
    $cotizaciones = Cotizacion::all();
    return view('cotizaciones.index', compact("cotizaciones"));
  }

  public function create(Request $request)
  {
    $unidades = Unidad::all();
    $tiposIGV = TipoIgv::all();
    $tiposDocumentoIdentidad = TipoDocumentoIdentidad::all();
    $tipoCambioDolar = TipoCambio::obtenerTipoCambioDolarDelDia();
    $monedas = Moneda::active();
    $productos = Producto::all();
    $entidades = Entidad::all();

    $cotizacionId = $request->query('cotizacionId');

    if ($cotizacionId) {

      $cotizacionBase = Cotizacion::with('cliente', 'moneda', 'detalles')->find($cotizacionId);

      dd($cotizacionBase);
    }

    $cotizacionBase = isset($cotizacionBase) ? $cotizacionBase : null;

    return view("cotizaciones.create", compact(
      "unidades",
      "tiposIGV",
      "tiposDocumentoIdentidad",
      "tipoCambioDolar",
      "monedas",
      "productos",
      "entidades",
      "cotizacionBase"
    ));
  }

  public function storeJSON(Request $request)
  {

    $validator = Validator::make($request->all(), [
      "cliente_id" => "required",
      "cliente_direccion" => "required",
      "moneda_id" => "required",
      "total_gravada" => "required",
      "total_igv" => "required",
      "total_a_pagar" => "required",
      "items" => "required",
    ]);

    if ($validator->fails()) {
      $ok = false;
      $error = $validator->errors()->all();
      return response()->json(compact("ok", "error"));
    }

    DB::beginTransaction();

    try {
      $cotizacionCreada = Cotizacion::create($request->all());

      $itemValidator = Validator::make($request->items, [
        "*.producto_id" => "required",
        "*.inventario_id" => "required",
        "*.descripcion" => "required",
        "*.descripcion_adicional" => "required",
        "*.codigo" => "required",
        "*.cantidad" => "required",
        "*.valor_venta" => "required",
        "*.tipo_igv_id" => "required",
        "*.unidad_id" => "required",
        "*.porcentaje_descuento" => "required",
      ]);

      if ($itemValidator->fails()) {
        DB::rollBack();
        $ok = false;
        $error = $itemValidator->errors()->all();
        return response()->json(compact("ok", "error"));
      }

      $cotizacionCreada->detalles()->createMany($request->items);

      // foreach ($request->items as $item) {

      // $cotizacionCreada->detalles()->create($item);

      // }

      DB::commit();
      $ok = true;
      $message = "Cotización registrada correctamente";

      return response()->json(compact("ok", "message"));
    } catch (\Throwable $th) {
      DB::rollBack();
      return response()->json([
        "ok" => false,
        "error" => $th->getMessage()
      ]);
    }
  }

  public function show(Cotizacion $cotizacion)
  {
    return view('cotizaciones.show', compact("cotizacion"));
  }

  public function pdf(Cotizacion $cotizacion)
  {
    // $pdf = \PDF::loadView('cotizaciones.pdf', compact("cotizacion"));
    // return $pdf->stream('cotizacion.pdf');
    //TODO: Generar PDF
    dd($cotizacion);
  }
}
