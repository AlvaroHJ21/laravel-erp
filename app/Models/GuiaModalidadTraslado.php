<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuiaModalidadTraslado extends Model
{
    use HasFactory;

    protected $table = 'guia_modalidades_traslado';

    protected $fillable = [
        'nombre',
    ];

    public $timestamps = false;
}
