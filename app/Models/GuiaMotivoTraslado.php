<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuiaMotivoTraslado extends Model
{
    use HasFactory;

    protected $table = 'guia_motivos_traslado';

    protected $fillable = [
        'nombre',
        'codigo',
    ];

    public $timestamps = false;
}
