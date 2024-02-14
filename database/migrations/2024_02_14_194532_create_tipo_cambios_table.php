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
        Schema::create('tipos_cambio', function (Blueprint $table) {
            $table->id();
            $table->foreignId('moneda_id')->constrained('monedas');
            $table->decimal('tipo_cambio_compra', 10, 3)->nullable();
            $table->decimal('tipo_cambio_venta', 10, 3)->nullable();
            $table->smallInteger('proveniente')->nullable();
            $table->string('encargado', 40)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipos_cambio');
    }
};
