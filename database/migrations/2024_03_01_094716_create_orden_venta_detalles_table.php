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
    Schema::create('orden_venta_detalles', function (Blueprint $table) {
      $table->id();
      $table->foreignId('orden_venta_id')->constrained("ordenes_venta")->cascadeOnDelete();
      $table->foreignId('inventario_id')->constrained("inventarios");
      $table->foreignId('producto_id')->constrained("productos");
      $table->text('descripcion_adicional')->nullable();
      $table->string('codigo', 20)->nullable();
      $table->unsignedBigInteger('cantidad')->nullable();
      $table->decimal('valor_venta', 10, 2)->nullable();
      $table->decimal('subtotal', 10, 2)->nullable();
      $table->foreignId('tipo_igv_id')->constrained("tipos_igv");
      $table->decimal('porcentaje_descuento', 10, 2)->default(0);
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('orden_venta_detalles');
  }
};
