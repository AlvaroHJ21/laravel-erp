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
    Schema::create('entidades', function (Blueprint $table) {
      $table->id();
      $table->string('nombre', 200);
      $table->foreignId('tipo_documento_id')->constrained('tipos_documento_identidad');
      $table->string('numero_documento', 11);
      $table->string('direccion', 200);
      $table->smallInteger('tipo');
      $table->string('telefono', 11);
      $table->string('correo', 100);
      $table->decimal('porcentaje_descuento', 10, 2)->default(0);
      $table->boolean('retencion')->default(false);
      $table->char('ubigeo', 6);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('entidades');
  }
};
