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
    Schema::create('cotizaciones', function (Blueprint $table) {
      $table->id();
      $table->foreignId('entidad_id')->constrained("entidades");
      $table->foreignId('moneda_id')->constrained("monedas");
      $table->decimal('total_gravada', 10, 2)->nullable();
      $table->decimal('total_igv', 10, 2)->nullable();
      $table->decimal('total_pagar', 10, 2)->nullable();
      $table->text('nota')->nullable();
      $table->unsignedSmallInteger('estado')->nullable();
      $table->boolean('enviado_cliente')->default(false);
      $table->foreignId('user_id')->constrained("users");
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('cotizaciones');
  }
};
