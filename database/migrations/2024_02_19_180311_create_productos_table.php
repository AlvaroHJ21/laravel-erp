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
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('codigo');
            $table->string('nombre');
            $table->decimal('precio_compra', 10, 4);
            $table->decimal('precio_venta', 10, 4);
            $table->decimal('valor_venta', 10, 4)->nullable();
            $table->string('imagen')->nullable();
            $table->foreignId('categoria_id')->constrained('categorias');
            $table->foreignId('unidad_id')->constrained('unidades');
            $table->foreignId('moneda_id')->constrained('monedas');
            $table->foreignId('tipo_igv_id')->constrained('tipos_igv');
            $table->foreignId('user_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
