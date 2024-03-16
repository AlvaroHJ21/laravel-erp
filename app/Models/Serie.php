<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
  use HasFactory;

  protected $table = "series";

  protected $fillable = [
    "tipo_documento_id",
    "serie",
    "ultimo_numero"
  ];

  public function tipo_documento()
  {
    return $this->belongsTo(TipoDocumento::class);
  }

  public function generateNumber()
  {
    $numero = $this->ultimo_numero + 1;
    $this->ultimo_numero = $numero;
    return $numero;
  }
}
