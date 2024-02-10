<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        DB::table('empresas')->insert([
            'ruc' => '12345678901',
            'razon_social' => 'Empresa de Prueba',
            'nombre_comercial' => 'Prueba Corp',
            'domicilio_fiscal' => 'Calle de Prueba 123',
            'ubigeo' => '010101',
            'urbanizacion' => 'Urbanización Prueba',
            'distrito' => 'Distrito Prueba',
            'provincia' => 'Provincia Prueba',
            'departamento' => 'Departamento Prueba',
            'telefono_fijo' => '123456789',
            'telefono_movil' => '987654321',
            'correo' => 'prueba@empresa.com',
            'logo' => 'ruta/al/logo.jpg',
            'codigo_sucursal_sunat' => '123456',
            'usu_secundario_usuario' => 'usuario_prueba',
            'usu_secundario_password' => 'password_prueba',
            'guias_client_id' => 'client_id_prueba',
            'guias_client_secret' => 'client_secret_prueba',
            'access_token' => 'token_de_acceso_prueba',
            'modo' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
