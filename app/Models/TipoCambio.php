<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoCambio extends Model
{
    use HasFactory;

    protected $table = 'tipos_cambio';

    protected $fillable = [
        'moneda_id',
        'tipo_cambio_compra',
        'tipo_cambio_venta',
        'proveniente',
        'encargado',
    ];

    public function moneda()
    {
        return $this->belongsTo(Moneda::class);
    }
}
