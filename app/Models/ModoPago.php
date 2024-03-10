<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModoPago extends Model
{
  use HasFactory;

  protected $table = 'modos_pago';
  protected $fillable = ['nombre'];

}
