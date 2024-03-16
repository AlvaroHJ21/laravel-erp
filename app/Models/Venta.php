<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
  use HasFactory;

  protected $table = 'ventas';

  protected $fillable = [
    'entidad_id',
    'tipo_documento_id',
    'serie_id',
    'numero',
    'fecha_emision',
    'fecha_vencimiento',
    'moneda_id',
    'total_gravada',
    'total_igv',
    'total_pagar',
    'tipo_operacion',
    'forma_pago_id',
    'modo_pago_id',
    'firma_sunat',
    'ticket_baja',
    'detraccion_codigo',
    'detraccion_porcentaje',
    'retencion_porcentaje',
    'nota',
    'nota_pago',
    'numero_orden_compra',
    'estado',
    'enviado_cliente',
    'user_id',
  ];

  public function entidad()
  {
    return $this->belongsTo(Entidad::class);
  }

  public function tipo_documento()
  {
    return $this->belongsTo(TipoDocumento::class);
  }

  public function serie()
  {
    return $this->belongsTo(Serie::class);
  }

  public function moneda()
  {
    return $this->belongsTo(Moneda::class);
  }

  public function forma_pago()
  {
    return $this->belongsTo(FormaPago::class);
  }

  public function modo_pago()
  {
    return $this->belongsTo(ModoPago::class);
  }

  public function user()
  {
    return $this->belongsTo(User::class);
  }

  public function detalles()
  {
    return $this->hasMany(VentaDetalle::class);
  }

  public function pagos()
  {
    return $this->hasMany(Pago::class);
  }
}
