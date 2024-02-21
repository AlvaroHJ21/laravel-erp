<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    use HasFactory;

    protected $table = "cotizaciones";

    protected $fillable = [
        'entidad_id',
        'cliente_direccion',
        'moneda_id',
        'total_gravada',
        'total_igv',
        'total_a_pagar',
        'nota',
        'estado',
        'enviado_cliente',
        'user_id'
    ];

    public function cliente()
    {
        return $this->belongsTo(Entidad::class, 'entidad_id');
    }

    public function moneda()
    {
        return $this->belongsTo(Moneda::class);
    }

    public function detalles()
    {
        return $this->hasMany(CotizacionDetalle::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
