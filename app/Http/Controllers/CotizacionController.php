<?php

namespace App\Http\Controllers;

use App\Models\Moneda;
use App\Models\Unidad;
use App\Models\TipoIgv;
use App\Models\Cotizacion;
use App\Models\Empresa;
use App\Models\Entidad;
use App\Models\Inventario;
use App\Models\Producto;
use App\Models\TipoCambio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TipoDocumentoIdentidad;
use App\Utils\Numletras;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Validator;

class CotizacionController extends Controller
{
  public function index()
  {
    $cotizaciones = Cotizacion::orderBy('created_at', 'desc')->get();
    return view('cotizaciones.index', compact("cotizaciones"));
  }

  public function create(Request $request)
  {
    $unidades = Unidad::all();
    $tiposIGV = TipoIgv::all();
    $tiposDocumentoIdentidad = TipoDocumentoIdentidad::all();
    $tipoCambioDolar = TipoCambio::obtenerTipoCambioDolarDelDia();
    $monedas = Moneda::active();
    $inventarios = Inventario::with('producto', 'almacen')->get();
    $entidades = Entidad::all();

    $cotizacionId = $request->query('cotizacionId');

    if ($cotizacionId) {

      $cotizacionBase = Cotizacion::with('cliente', 'moneda', 'detalles', 'detalles.producto')->find($cotizacionId);
    }

    $cotizacionBase = isset($cotizacionBase) ? $cotizacionBase : null;

    return view("cotizaciones.create", compact(
      "unidades",
      "tiposIGV",
      "tiposDocumentoIdentidad",
      "tipoCambioDolar",
      "monedas",
      "inventarios",
      "entidades",
      "cotizacionBase"
    ));
  }

  public function storeJSON(Request $request)
  {

    $validator = Validator::make($request->all(), [
      "entidad_id" => "required",
      "moneda_id" => "required",
      "total_gravada" => "required",
      "total_igv" => "required",
      "total_pagar" => "required",
      "items" => "required",
    ]);

    if ($validator->fails()) {
      $ok = false;
      $error = $validator->errors()->all();
      return response()->json(compact("ok", "error"));
    }

    $request->merge([
      "user_id" => auth()->id(),
    ]);

    DB::beginTransaction();

    try {
      $cotizacionCreada = Cotizacion::create($request->all());

      $itemValidator = Validator::make($request->items, [
        "*.producto_id" => "required",
        "*.descripcion_adicional" => "nullable|string",
        "*.codigo" => "required",
        "*.cantidad" => "required",
        "*.valor_venta" => "required",
        "*.subtotal" => "required",
        "*.tipo_igv_id" => "required",
        "*.porcentaje_descuento" => "required",
      ]);

      if ($itemValidator->fails()) {
        DB::rollBack();
        $ok = false;
        $error = $itemValidator->errors()->all();
        return response()->json(compact("ok", "error"));
      }

      $cotizacionCreada->detalles()->createMany($request->items);

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
    $cotizacion->load('cliente', 'moneda', 'detalles', 'detalles.producto', 'detalles.tipoIgv');
    return view('cotizaciones.show', compact("cotizacion"));
  }


  public function pdf(Cotizacion $cotizacion)
  {
    //generar un pdf
    $logo = public_path('img/logo.png');
    // dd($logo);
    $cotizacion->load([
      "cliente",
      "moneda",
      "detalles",
      "detalles.producto",
    ]);

    $entidad = $cotizacion->cliente;
    $moneda = $cotizacion->moneda;
    $items = $cotizacion->detalles;
    $empresa = Empresa::first();

    $num2letras = new Numletras();

    $totalLetras = $num2letras->getTotalLetras($cotizacion->total_pagar, $moneda->nombre);

    $pdf = Pdf::loadView("cotizaciones.pdf", compact(
      "logo",
      "cotizacion",
      "items",
      "empresa",
      "entidad",
      "moneda",
      "totalLetras"
    ));

    return $pdf->stream();
  }
}
