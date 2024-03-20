<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pago extends Model
{
  use HasFactory;

  protected $table = 'pagos';

  protected $fillable = [
    'fecha',
    'monto',
    'venta_id',
  ];


  protected $casts = [
    'monto' => 'float',
  ];
}
