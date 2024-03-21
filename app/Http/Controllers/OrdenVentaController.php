<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrdenVentaStoreRequest;
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

      $base = OrdenVenta::with('entidad', 'moneda', 'detalles', 'detalles.producto')->find($fromId);
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

  public function store(OrdenVentaStoreRequest $request)
  {
    try {
      DB::beginTransaction();
      $data = $request->validated();
      $data['user_id'] = auth()->id();

      $ordenVentaCreada = OrdenVenta::create($data);
      $ordenVentaCreada->detalles()->createMany($request->items);

      //actualizar el stock
      foreach ($request->items as $item) {

        $inventario = Inventario::find($item['inventario_id']);
        $cantidadSolicitada = $item['cantidad'];

        if ($inventario->cantidad < $cantidadSolicitada) {
          throw new \Exception("La cantidad solicitada de {$inventario->producto->nombre} es mayor al stock actual");
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
    $ordenVenta->load('entidad', 'moneda', 'detalles', 'detalles.producto', 'detalles.tipoIgv');
    return view('ordenes_venta.show', compact("ordenVenta"));
  }


  public function pdf(OrdenVenta $ordenVenta)
  {
    //generar un pdf
    $logo = public_path('img/logo.png');
    // dd($logo);
    $ordenVenta->load([
      "entidad",
      "moneda",
      "detalles",
      "detalles.producto",
    ]);

    $entidad = $ordenVenta->entidad;
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
