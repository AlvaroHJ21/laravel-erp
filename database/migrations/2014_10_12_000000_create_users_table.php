<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create('users', function (Blueprint $table) {
      $table->id();
      $table->string('name');
      $table->string('username');
      $table->string('email')->unique();
      $table->smallInteger('rol')->default(0); // 0: user, 1: admin
      $table->timestamp('email_verified_at')->nullable();
      $table->string('password');
      $table->rememberToken();
      $table->timestamps();
    });

    // Insertar usuario administrador
    DB::table('users')->insert([
      'name' => 'Alvaro Huaysara Jauregui',
      'email' => 'alvaro@gmail.com',
      'username' => 'alvarohj',
      'password' => bcrypt('12345678'),
      'rol' => 1
    ]);
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists('users');
  }
};
