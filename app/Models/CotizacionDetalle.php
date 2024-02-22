<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CotizacionDetalle extends Model
{
  use HasFactory;

  protected $table = "cotizacion_detalles";

  protected $fillable = [
    'cotizacion_id',
    'producto_id',
    'descripcion_adicional',
    'codigo',
    'cantidad',
    'tipo_igv_id',
    'valor_venta',
    'porcentaje_descuento',
    'subtotal',
  ];
}
