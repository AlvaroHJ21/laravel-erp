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
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->string('ruc', 11)->nullable();
            $table->string('razon_social')->nullable();
            $table->string('nombre_comercial')->nullable();
            $table->string('domicilio_fiscal')->nullable();
            $table->char('ubigeo', 6)->nullable();
            $table->string('urbanizacion', 100)->nullable();
            $table->string('distrito', 20)->nullable();
            $table->string('provincia', 20)->nullable();
            $table->string('departamento', 20)->nullable();
            $table->string('telefono_fijo', 20)->nullable();
            $table->string('telefono_movil', 10)->nullable();
            $table->string('correo', 150)->nullable();
            $table->string('logo', 255)->nullable();
            $table->string('web', 255)->nullable();
            $table->string('codigo_sucursal_sunat', 10)->nullable();
            $table->string('usu_secundario_usuario', 150)->nullable();
            $table->string('usu_secundario_password', 150)->nullable();
            $table->string('guias_client_id', 60)->nullable();
            $table->string('guias_client_secret', 50)->nullable();
            $table->text('access_token')->nullable();
            $table->smallInteger('modo')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresas');
    }
};
