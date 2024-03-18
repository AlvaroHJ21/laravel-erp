<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VentaDetalle extends Model
{
  use HasFactory;

  protected $table = 'venta_detalles';

  protected $fillable = [
    'venta_id',
    'producto_id',
    'inventario_id',
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

  public function inventario()
  {
    return $this->belongsTo(Inventario::class);
  }

  public function tipo_igv()
  {
    return $this->belongsTo(TipoIgv::class);
  }
}
