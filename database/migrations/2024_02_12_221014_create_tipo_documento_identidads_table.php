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
        Schema::create('tipos_documento_identidad', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 60);
            $table->string('codigo', 10);
            $table->string('descripcion', 60);
            $table->string('abreviado', 8)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tipos_documento_identidad');
    }
};
