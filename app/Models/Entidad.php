<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entidad extends Model
{
    use HasFactory;

    protected $table = "entidades";

    protected $fillable = [
        'nombre',
        'tipo_documento_id',
        'numero_documento',
        'direccion',
        'tipo',
        'telefono',
        'correo',
        'porcentaje_descuento',
        'retencion',
        'ubigeo',
    ];

    public function documento_identidad()
    {
        return $this->belongsTo(TipoDocumentoIdentidad::class, 'tipo_documento_id');
    }
}
