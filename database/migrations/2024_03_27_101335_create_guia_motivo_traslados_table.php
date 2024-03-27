<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('guia_motivos_traslado', function (Blueprint $table) {
      $table->id();
      $table->string("nombre", 100);
      $table->string('codigo', 2)->unique();
    });

    DB::table('guia_motivos_traslado')->insert([
      ['nombre' => 'Venta', "codigo" => "01"],
      ['nombre' => 'Compra', "codigo" => "02"],
      ['nombre' => 'Venta con entrega a terceros', "codigo" => "03"],
      ['nombre' => 'Traslado entre establecimientos de la misma empresa', "codigo" => "04"],
      ['nombre' => 'Consignación', "codigo" => "05"],
      ['nombre' => 'Devolución', "codigo" => "06"],
      ['nombre' => 'Recojo de bienes transformados', "codigo" => "07"],
      ['nombre' => 'Importación', "codigo" => "08"],
      ['nombre' => 'Exportación', "codigo" => "09"],
      ['nombre' => 'Otros', "codigo" => "13"],
      ['nombre' => 'Venta sujeta a confirmación del comprador', "codigo" => "14"],
      ['nombre' => 'Traslado de bienes para transformación', "codigo" => "17"],
      ['nombre' => 'Traslado emisor itinerante CP', "codigo" => "18"],
    ]);
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('guia_motivos_traslado');
  }
};
