<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoIgv extends Model
{
    use HasFactory;

    protected $table = "tipos_igv";

    public $timestamps = false;
}
