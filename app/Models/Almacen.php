<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Almacen extends Model
{
    use HasFactory;

    protected $table = 'almacenes';
    protected $fillable = ['nombre', 'activo', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function inventarios()
    {
        return $this->hasMany(Inventario::class);
    }
}
