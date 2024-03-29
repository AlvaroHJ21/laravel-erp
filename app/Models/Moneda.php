<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Moneda extends Model
{
    use HasFactory;

    protected $table = "monedas";

    protected $fillable = [
        "nombre",
        "simbolo",
        "activo"
    ];

    public $timestamps = false;

    public static function active()
    {
        return Moneda::where("activo", 1)->get();
    }
}
