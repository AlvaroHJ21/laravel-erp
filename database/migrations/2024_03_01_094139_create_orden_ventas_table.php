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
    Schema::create('ordenes_venta', function (Blueprint $table) {
      $table->id();
      $table->foreignId('entidad_id')->constrained("entidades");
      $table->foreignId('moneda_id')->constrained("monedas");
      $table->decimal('total_gravada', 10, 2);
      $table->decimal('total_igv', 10, 2);
      $table->decimal('total_pagar', 10, 2);
      $table->text('nota')->nullable();
      $table->unsignedSmallInteger('estado');
      $table->boolean('enviado_cliente')->default(false);
      $table->foreignId('user_id')->constrained("users");

      $table->foreignId('cotizacion_id')->nullable()->constrained("cotizaciones");
      $table->string('numero_orden_compra');

      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('ordenes_venta');
  }
};
