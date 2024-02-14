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
    ];

    public function tipo_documento()
    {
        return $this->belongsTo(TipoDocumento::class);
    }
}
