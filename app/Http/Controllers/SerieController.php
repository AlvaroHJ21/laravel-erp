<?php

namespace App\Http\Controllers;

use App\Models\Serie;
use App\Models\TipoDocumento;
use Illuminate\Http\Request;

class SerieController extends Controller
{
    public function index()
    {
        $series = Serie::all();

        $tiposDocumento = TipoDocumento::all();

        return view("configuracion.series", compact("series", "tiposDocumento"));
    }

    public function create(Request $request)
    {
        $request->validate([
            "tipo_documento_id" => "required",
            "serie" => "required",
        ]);

        Serie::create($request->all());

        return redirect()->route("series.index");
    }
}
