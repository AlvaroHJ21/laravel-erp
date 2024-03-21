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
    'inventario_id',
    'descripcion_adicional',
    'codigo',
    'cantidad',
    'tipo_igv_id',
    'valor_venta',
    'porcentaje_descuento',
    'subtotal',
  ];

  public function producto()
  {
    return $this->belongsTo(Producto::class);
  }

  public function inventario()
  {
    return $this->belongsTo(Inventario::class);
  }

  public function tipo_igv()
  {
    return $this->belongsTo(TipoIgv::class);
  }
}
