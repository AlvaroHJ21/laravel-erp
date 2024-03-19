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
    Schema::create('ventas', function (Blueprint $table) {
      $table->id();
      $table->foreignId('entidad_id')->constrained("entidades");
      $table->foreignId('tipo_documento_id')->constrained("tipos_documento");
      $table->foreignId('serie_id')->constrained("series");
      $table->unsignedInteger('numero');
      $table->date('fecha_emision');
      $table->date('fecha_vencimiento');
      $table->foreignId('moneda_id')->constrained("monedas");
      $table->decimal('total_gravada', 10, 2);
      $table->decimal('total_igv', 10, 2);
      $table->decimal('total_pagar', 10, 2);
      $table->string('tipo_operacion', 4);
      $table->unsignedBigInteger('forma_pago_id');
      $table->unsignedBigInteger('modo_pago_id');
      $table->string('nombre_archivo', 100)->nullable();
      $table->string('firma_sunat', 100)->nullable();
      $table->string('ticket_baja', 15)->nullable();
      $table->string('detraccion_codigo', 4)->nullable();
      $table->decimal('detraccion_porcentaje', 10, 2)->nullable();
      $table->decimal('retencion_porcentaje', 10, 2)->nullable();
      $table->text('nota')->nullable();
      $table->text('nota_pago')->nullable();
      $table->string('numero_orden_compra');
      $table->unsignedBigInteger('estado')->default(0);
      $table->boolean('enviado_cliente')->default(false);
      $table->foreignId('user_id')->constrained("users");
      $table->foreignId("orden_venta_id")->nullable()->constrained("ordenes_venta");
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('ventas');
  }
};
