<?php

namespace App\Http\Controllers;

use App\Models\Empresa;
use App\Models\Entidad;
use App\Models\Inventario;
use App\Models\Moneda;
use App\Models\OrdenVenta;
use App\Models\TipoCambio;
use App\Models\TipoDocumentoIdentidad;
use App\Models\TipoIgv;
use App\Models\Unidad;
use App\Utils\Numletras;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrdenVentaController extends Controller
{
  public function index()
  {
    $ordenesVenta = OrdenVenta::orderBy('created_at', 'desc')->get();
    return view('ordenes_venta.index', compact("ordenesVenta"));
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

    $fromId = $request->query('fromId');

    if ($fromId) {

      $base = OrdenVenta::with('cliente', 'moneda', 'detalles', 'detalles.producto')->find($fromId);
    }

    $base = isset($base) ? $base : null;

    return view("ordenes_venta.create", compact(
      "unidades",
      "tiposIGV",
      "tiposDocumentoIdentidad",
      "tipoCambioDolar",
      "monedas",
      "inventarios",
      "entidades",
      "base"
    ));
  }

  public function storeJSON(Request $request)
  {

    $validator = Validator::make($request->all(), [
      "numero_orden_compra" => "required",
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
      $ordenVentaCreada = OrdenVenta::create($request->all());

      $itemValidator = Validator::make($request->items, [
        "*.producto_id" => "required",
        "*.inventario_id" => "required",
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

      $ordenVentaCreada->detalles()->createMany($request->items);

      //actualizar el stock
      foreach ($request->items as $item) {

        $inventario = Inventario::find($item['inventario_id']);
        $cantidadSolicitada = $item['cantidad'];

        if ($inventario->cantidad < $cantidadSolicitada) {
          DB::rollBack();
          $ok = false;
          $error = "La cantidad solicitada de {$inventario->producto->nombre} es mayor al stock actual";
          return response()->json(compact("ok", "error"));
        }

        $inventario->decrement('cantidad', $cantidadSolicitada);
      }

      DB::commit();
      $ok = true;
      $message = "Orden de venta registrada correctamente";

      return response()->json(compact("ok", "message"));
    } catch (\Throwable $th) {
      DB::rollBack();
      return response()->json([
        "ok" => false,
        "error" => $th->getMessage()
      ]);
    }
  }

  public function show(OrdenVenta $ordenVenta)
  {
    $ordenVenta->load('cliente', 'moneda', 'detalles', 'detalles.producto', 'detalles.tipoIgv');
    return view('ordenes_venta.show', compact("ordenVenta"));
  }


  public function pdf(OrdenVenta $ordenVenta)
  {
    //generar un pdf
    $logo = public_path('img/logo.png');
    // dd($logo);
    $ordenVenta->load([
      "cliente",
      "moneda",
      "detalles",
      "detalles.producto",
    ]);

    $entidad = $ordenVenta->cliente;
    $moneda = $ordenVenta->moneda;
    $items = $ordenVenta->detalles;
    $empresa = Empresa::first();

    $num2letras = new Numletras();

    $totalLetras = $num2letras->getTotalLetras($ordenVenta->total_pagar, $moneda->nombre);

    $pdf = Pdf::loadView("ordenes_venta.pdf", compact(
      "logo",
      "ordenVenta",
      "items",
      "empresa",
      "entidad",
      "moneda",
      "totalLetras"
    ));

    return $pdf->stream();
  }
}
