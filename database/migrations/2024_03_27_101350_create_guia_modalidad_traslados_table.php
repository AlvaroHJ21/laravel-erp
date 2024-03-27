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
    Schema::create('guia_modalidades_traslado', function (Blueprint $table) {
      $table->id();
      $table->string('nombre', 100);
    });

    DB::table('guia_modalidades_traslado')->insert([
      ['nombre' => 'Transporte público'],
      ['nombre' => 'Transporte privado'],
    ]);
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('guia_modalidades_traslado');
  }
};
