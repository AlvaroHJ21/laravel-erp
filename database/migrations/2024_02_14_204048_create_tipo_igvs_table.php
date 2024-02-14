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
        Schema::create('tipos_igv', function (Blueprint $table) {
            $table->id();
            $table->char('codigo', 2)->nullable();
            $table->string('tipo_igv', 60)->nullable();
            $table->char('codigo_de_tributo', 4)->nullable();
            $table->boolean('activo')->default(0);
            $table->decimal('porcentaje', 10, 3)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipos_igv');
    }
};
