<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('guias', function (Blueprint $table) {
      $table->id();
      $table->foreignId('cliente_id')->constrained("entidades");
      $table->foreignId('serie_id')->constrained("series");
      $table->unsignedInteger('numero');
      $table->date('fecha_emision');
      $table->date('fecha_traslado');

      $table->foreignId('guia_motivo_traslado_id')->constrained("guia_motivos_traslado");
      $table->foreignId('guia_modalidad_traslado_id')->constrained("guia_modalidades_traslado");
      $table->foreignId('vehiculo_id')->constrained("vehiculos");
      // $table->string('vehiculo_placa', 11)->nullable();
      // $table->string('vehiculo_marca', 100)->nullable();
      // $table->string('vehiculo_modelo', 100)->nullable();
      // $table->smallInteger('vehiculo_categoria_m1_l')->nullable();

      $table->foreignId('conductor_id')->constrained("entidades");
      // $table->string('conductor_licencia', 11)->nullable(); //!

      $table->foreignId('transportista_id')->constrained("entidades");
      // $table->string('transportista_mtc', 11)->nullable(); //!

      $table->string('origen_ubigeo', 6);
      $table->string('origen_direccion', 100);
      $table->string('destino_ubigeo', 6);
      $table->string('destino_direccion', 100);

      $table->decimal('peso_total', 10, 2);
      $table->unsignedInteger('numero_bultos');

      $table->string('ticket', 100)->nullable();
      $table->text('nota')->nullable();
      $table->string('numero_orden_compra', 20)->nullable();
      $table->unsignedBigInteger('estado')->nullable();

      $table->foreignId('user_id');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('guias');
  }
};
