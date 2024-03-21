<?php

namespace App\Http\Controllers;

use App\Http\Requests\CotizacionStoreRequest;
use App\Models\Moneda;
use App\Models\Unidad;
use App\Models\TipoIgv;
use App\Models\Cotizacion;
use App\Models\Empresa;
use App\Models\Entidad;
use App\Models\Inventario;
use App\Models\TipoCambio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\TipoDocumentoIdentidad;
use App\Utils\Numletras;
use Barryvdh\DomPDF\Facade\Pdf;

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

      $base = Cotizacion::with('entidad', 'moneda', 'detalles', 'detalles.producto')->find($cotizacionId);
    }

    $base = isset($base) ? $base : null;

    return view("cotizaciones.create", compact(
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

  public function store(CotizacionStoreRequest $request)
  {
    try {
      $data = $request->validated();
      $data["user_id"] = auth()->id();

      DB::beginTransaction();
      $cotizacionCreada = Cotizacion::create($data);
      $cotizacionCreada->detalles()->createMany($request->items);

      DB::commit();
      $ok = true;
      $message = "Cotización registrada correctamente";

      return response()->json(compact("ok", "message"));
    } catch (\Throwable $th) {
      DB::rollBack();
      return response()->json([
        "ok" => false,
        "message" => $th->getMessage()
      ]);
    }
  }

  public function show(Cotizacion $cotizacion)
  {
    $cotizacion->load('entidad', 'moneda', 'detalles', 'detalles.producto', 'detalles.tipo_igv');
    return view('cotizaciones.show', compact("cotizacion"));
  }


  public function pdf(Cotizacion $cotizacion)
  {
    //generar un pdf
    $logo = public_path('img/logo.png');
    // dd($logo);
    $cotizacion->load([
      "entidad",
      "moneda",
      "detalles",
      "detalles.producto",
    ]);

    $entidad = $cotizacion->entidad;
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
