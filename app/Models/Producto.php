<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';
    protected $fillable = [
        "codigo",
        "nombre",
        "precio_compra",
        "precio_venta",
        "valor_venta",
        "imagen",
        "categoria_id",
        "unidad_id",
        "moneda_id",
        "tipo_igv_id",
        "user_id",
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function unidad()
    {
        return $this->belongsTo(Unidad::class);
    }

    public function moneda()
    {
        return $this->belongsTo(Moneda::class);
    }

    public function tipoIgv()
    {
        return $this->belongsTo(TipoIgv::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
