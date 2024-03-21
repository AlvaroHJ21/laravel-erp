<?php

namespace App\Http\Controllers;

use App\Http\Requests\VentaStoreRequest;
use App\Models\Empresa;
use App\Models\Entidad;
use App\Models\FormaPago;
use App\Models\Inventario;
use App\Models\ModoPago;
use App\Models\Moneda;
use App\Models\OrdenVenta;
use App\Models\Serie;
use App\Models\TipoCambio;
use App\Models\TipoDocumento;
use App\Models\TipoDocumentoIdentidad;
use App\Models\TipoIgv;
use App\Models\Unidad;
use App\Models\Venta;
use App\Utils\Numletras;
use App\Utils\SendSunnat;
use Barryvdh\DomPDF\Facade\Pdf;
use Greenter\See;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class VentaController extends Controller
{
  public function index(Request $request)
  {
    $ventas = Venta::orderBy('created_at', 'desc')->get();
    return view('ventas.index', compact("ventas"));
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
    $tiposDocumento = TipoDocumento::with('series')->get();
    $formasPago = FormaPago::all();
    $modosPago = ModoPago::all();

    $ventaId = $request->query('ventaId');
    if ($ventaId) {
      $base = Venta::with('entidad', 'moneda', 'detalles', 'detalles.producto', 'detalles.tipo_igv', 'pagos',)->find($ventaId);
    }
    $base = isset($base) ? $base : null;
    $ordenVenta = null;

    return view('ventas.create', compact(
      "unidades",
      "tiposIGV",
      "tiposDocumento",
      "tiposDocumentoIdentidad",
      "tipoCambioDolar",
      "monedas",
      "inventarios",
      "entidades",
      "formasPago",
      "modosPago",
      "base",
      'ordenVenta'
    ));
  }

  public function createByOrdenVenta(OrdenVenta $ordenVenta)
  {
    $unidades = Unidad::all();
    $tiposIGV = TipoIgv::all();
    $tiposDocumentoIdentidad = TipoDocumentoIdentidad::all();
    $tipoCambioDolar = TipoCambio::obtenerTipoCambioDolarDelDia();
    $monedas = Moneda::active();
    $inventarios = Inventario::with('producto', 'almacen')->get();
    $entidades = Entidad::all();
    $tiposDocumento = TipoDocumento::with('series')->get();
    $formasPago = FormaPago::all();
    $modosPago = ModoPago::all();

    $base =  null;
    $ordenVenta->load('entidad', 'moneda', 'detalles', 'detalles.producto', 'detalles.tipo_igv');

    return view('ventas.create', compact(
      "unidades",
      "tiposIGV",
      "tiposDocumento",
      "tiposDocumentoIdentidad",
      "tipoCambioDolar",
      "monedas",
      "inventarios",
      "entidades",
      "formasPago",
      "modosPago",
      "base",
      'ordenVenta'
    ));
  }

  public function store(VentaStoreRequest $request)
  {

    try {
      DB::beginTransaction();

      $serie = Serie::find($request->serie_id);
      $numero = $serie->generateNumber();
      $request->merge([
        "numero" => $numero,
        "tipo_operacion" => "01", //TODO: enviar desde el front
        "user_id" => Auth::id(),
      ]);

      $venta = Venta::create($request->all());

      $venta->detalles()->createMany($request->items);

      $venta->pagos()->createMany($request->pagos);

      DB::commit();
      return response()->json([
        "message" => "Venta registrada correctamente",
      ]);
    } catch (\Throwable $th) {
      //throw $th;
      DB::rollBack();
      return response()->json([
        "message" => "Error al registrar la venta",
        "error" => $th->getMessage(),
      ], 500);
    }
  }

  public function show(Venta $venta)
  {
    $venta->load('entidad', 'moneda', 'detalles', 'detalles.producto', 'detalles.tipo_igv');
    return view('ventas.show', compact("venta"));
  }

  public function pdf(Venta $venta)
  {
    //generar un pdf
    $logo = public_path('img/logo.png');
    // dd($logo);
    $venta->load([
      "entidad",
      "moneda",
      "detalles",
      "detalles.producto",
    ]);

    $entidad = $venta->entidad;
    $moneda = $venta->moneda;
    $items = $venta->detalles;
    $empresa = Empresa::first();
    $cuotas = $venta->pagos;

    $num2letras = new Numletras();

    $totalLetras = $num2letras->getTotalLetras($venta->total_pagar, $moneda->nombre);

    $qrText = '';
    $qrText .= $empresa->ruc . "|"; //RUC EMPRESA
    $qrText .= $venta->tipo_documento->codigo . "|"; //TIPO DE DOCUMENTO
    $qrText .= $venta->serie->serie . "|"; //SERIE
    $qrText .= $venta->numero . "|"; //NUMERO
    $qrText .= $venta->total_igv . "|"; //MTO TOTAL IGV
    $qrText .= $venta->total_pagar . "|"; //MTO TOTAL DEL COMPROBANTE
    $qrText .= $venta->fecha_emision . "|"; //FECHA DE EMISION
    $qrText .= $entidad->documento_identidad->codigo . "|"; //TIPO DE DOCUMENTO ADQUIRENTE
    $qrText .= $entidad->numero_documento . "|"; //NUMERO DE DOCUMENTO ADQUIRENTE
    $qrText .= $venta->firma_sunat;

    $qr = QrCode::size(100)->generate($qrText);

    $pdf = Pdf::loadView("ventas.pdf", compact(
      "logo",
      "venta",
      "items",
      "empresa",
      "entidad",
      "moneda",
      "totalLetras",
      "cuotas",
      "qr"
    ));

    return $pdf->stream();
  }

  public function sendSunnat(Venta $venta)
  {
    try {
      SendSunnat::sendSale($venta);
      return redirect()->route('ventas.index');
    } catch (\Throwable $th) {
      return back()->with('error', $th->getMessage());
    }
  }

  public function xml(Venta $venta)
  {
    if ($venta->nombre_archivo) {

      if (Storage::disk('local')->exists('xml/' . $venta->nombre_archivo . '.xml')) {
        return response()
          ->file(
            storage_path(
              'app/xml/' . $venta->nombre_archivo . '.xml'
            )
          );
      } else {
        return response()->json([
          "message" => "Archivo no encontrado"
        ], 404);
      }
    } else {
      return response()->json([
        "message" => "Archivo no encontrado"
      ], 404);
    }
  }

  public function cdr(Venta $venta)
  {
    if ($venta->nombre_archivo) {

      if (Storage::disk('local')->exists('cdr/R-' . $venta->nombre_archivo . '.zip')) {
        return response()->download(
          storage_path(
            'app/cdr/R-' . $venta->nombre_archivo . '.zip'
          )
        );
      }
    } else {
      return response()->json([
        "message" => "Archivo no encontrado"
      ], 404);
    }
  }
}
