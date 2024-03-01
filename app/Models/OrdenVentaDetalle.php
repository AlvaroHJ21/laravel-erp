<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenVentaDetalle extends Model
{
  use HasFactory;

  protected $table = 'orden_venta_detalles';

  protected $fillable = [
    'orden_venta_id',
    'producto_id',
    'descripcion_adicional',
    'codigo',
    'cantidad',
    'valor_venta',
    'subtotal',
    'tipo_igv_id',
    'porcentaje_descuento',
  ];

  public function producto()
  {
    return $this->belongsTo(Producto::class);
  }

  public function tipoIgv()
  {
    return $this->belongsTo(TipoIgv::class);
  }
}
