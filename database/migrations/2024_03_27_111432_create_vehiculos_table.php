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
    Schema::create('vehiculos', function (Blueprint $table) {
      $table->id();
      $table->string('placa', 11);
      $table->string('marca', 100);
      $table->string('modelo', 100);
      $table->boolean('categoria_m1_l')->default(false);
      $table->foreignId('user_id');
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('vehiculos');
  }
};
