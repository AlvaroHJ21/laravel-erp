<?php

namespace App\Http\Controllers;

use App\Http\Requests\VentaStoreRequest;
use App\Models\Entidad;
use App\Models\FormaPago;
use App\Models\Inventario;
use App\Models\ModoPago;
use App\Models\Moneda;
use App\Models\TipoCambio;
use App\Models\TipoDocumento;
use App\Models\TipoDocumentoIdentidad;
use App\Models\TipoIgv;
use App\Models\Unidad;
use App\Models\Venta;
use Illuminate\Http\Request;

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
    $tiposDocumento = TipoDocumento::all();
    $formasPago = FormaPago::all();
    $modosPago = ModoPago::all();

    $ventaId = $request->query('ventaId');
    if ($ventaId) {
      $base = Venta::with('cliente', 'moneda', 'detalles', 'detalles.producto')->find($ventaId);
    }
    $base = isset($base) ? $base : null;
    return view('ventas.create', compact(
      "unidades",
      "tiposIGV",
      "tiposDocumento",
      "tiposDocumentoIdentidad",
      "tipoCambioDolar",
      "monedas",
      "inventarios",
      "entidades",
      "base",
      "formasPago",
      "modosPago",
    ));
  }

  public function store(VentaStoreRequest $request)
  {
  }
}
