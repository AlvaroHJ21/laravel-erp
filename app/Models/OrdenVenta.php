<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrdenVenta extends Model
{
  use HasFactory;

  protected $table = 'ordenes_venta';

  protected $fillable = [
    'entidad_id',
    'moneda_id',
    'total_gravada',
    'total_igv',
    'total_pagar',
    'nota',
    'estado',
    'enviado_cliente',
    'user_id',
    'cotizacion_id',
    'numero_orden_compra',
  ];


  public function entidad()
  {
    return $this->belongsTo(Entidad::class, 'entidad_id');
  }

  public function moneda()
  {
    return $this->belongsTo(Moneda::class);
  }

  public function detalles()
  {
    return $this->hasMany(OrdenVentaDetalle::class);
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function ventas()
  {
    return $this->hasMany(Venta::class);
  }
}
