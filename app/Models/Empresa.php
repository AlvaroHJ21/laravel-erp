<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;

    protected $table = 'empresas';

    protected $fillable = [
        'ruc',
        'razon_social',
        'nombre_comercial',
        'domicilio_fiscal',
        'ubigeo',
        'urbanizacion',
        'distrito',
        'provincia',
        'departamento',
        'telefono_fijo',
        'telefono_movil',
        'correo',
        'logo',
        'codigo_sucursal_sunat',
        'usu_secundario_usuario',
        'usu_secundario_password',
        'guias_client_id',
        'guias_client_secret',
        'access_token',
        'modo',
    ];
}
