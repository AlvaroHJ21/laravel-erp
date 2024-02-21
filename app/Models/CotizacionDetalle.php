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
        'descripcion',
        'descripcion_adicional',
        'codigo',
        'cantidad',
        'valor_venta',
        'tipo_igv_id',
        'unidad_id',
        'porcentaje_descuento'
    ];
}
