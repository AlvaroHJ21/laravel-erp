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

    \App\Models\User::factory()->create([
      'name' => 'Alvaro Huaysara Jauregui',
      'email' => 'alvaro@gmail.com',
      'password' => bcrypt('12345678'),
      'rol' => 1
    ]);

    // Empresas

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

    //Tipos documento de identidad

    DB::table('tipos_documento_identidad')->insert([
      'nombre' => 'DNI',
      'codigo' => 1,
      'descripcion' => 'Documento Nacional de Identidad',
      'abreviado' => 'DNI',
    ]);
    DB::table('tipos_documento_identidad')->insert([
      'nombre' => 'RUC',
      'codigo' => 6,
      'descripcion' => 'Registro Único de Contribuyentes',
      'abreviado' => 'RUC',
    ]);

    // Entidades

    DB::table('entidades')->insert([
      'nombre' => 'Alvaro Huaysara Jauregui',
      'tipo_documento_id' => 1,
      'numero_documento' => '12345678',
      'direccion' => 'Calle de Prueba 123',
      'tipo' => 1,
      'telefono' => '123456789',
      'correo' => 'alvaro@gmail.com',
      'created_at' => now(),
      'updated_at' => now(),
    ]);

    // Tipos de documento

    DB::table('tipos_documento')->insert([
      'codigo' => 1,
      'nombre' => 'Factura',
      'abreviado' => 'FAC',
    ]);
    DB::table('tipos_documento')->insert([
      'codigo' => 3,
      'nombre' => 'Boleta',
      'abreviado' => 'BOL',
    ]);

    // Monedas

    DB::table('monedas')->insert([
      'nombre' => 'Soles',
      'abreviado' => 'sol',
      'abrstandar' => 'PEN',
      'simbolo' => 'S/',
      'activo' => 1,
    ]);
    DB::table('monedas')->insert([
      'nombre' => 'Dólares',
      'abreviado' => 'dol',
      'abrstandar' => 'USD',
      'simbolo' => '$',
      'activo' => 1,
    ]);

    // Unidades

    DB::table('unidades')->insert([
      'codigo' => 'NIU',
      'unidad' => 'UNIDAD (BIENES)',
      'activo' => 1,
    ]);
    DB::table('unidades')->insert([
      'codigo' => 'ZZ',
      'unidad' => 'UNIDAD (SERVICIOS)',
      'activo' => 1,
    ]);

    // Tipos igv

    DB::table('tipos_igv')->insert([
      'codigo' => 1,
      'tipo_igv' => 'Gravado',
      'codigo_de_tributo' => '1000',
      'activo' => 1,
      'porcentaje' => 18,
    ]);

    DB::table('tipos_igv')->insert([
      'codigo' => 2,
      'tipo_igv' => 'Exonerado',
      'codigo_de_tributo' => '9997',
      'activo' => 1,
      'porcentaje' => 0,
    ]);

    // Categoria
    DB::table('categorias')->insert([
      "codigo" => "S01",
      'nombre' => 'Sensores',
      "created_at" => now(),
      "updated_at" => now(),
    ]);

    //Productos
    DB::table('productos')->insert([
      "codigo" => "P001",
      "nombre" => "Sensor de temperatura",
      "imagen" => "1686613875_0561e0e016280b29005a.jpg",
      "precio_compra" => 8,
      "precio_venta" => 10,
      "valor_venta" => 11.8,
      "categoria_id" => 1,
      "unidad_id" => 1,
      "moneda_id" => 1,
      "tipo_igv_id" => 1,
      "user_id" => 1,
      "created_at" => now(),
      "updated_at" => now(),
    ]);

    DB::table('productos')->insert([
      "codigo" => "P002",
      "nombre" => "Cámara de seguridad",
      "imagen" => "1686614027_6e5caf68649b3b991cd1.jpg",
      "precio_compra" => 80,
      "precio_venta" => 100,
      "valor_venta" => 118,
      "categoria_id" => 1,
      "unidad_id" => 1,
      "moneda_id" => 1,
      "tipo_igv_id" => 1,
      "user_id" => 1,
      "created_at" => now(),
      "updated_at" => now(),
    ]);

    //Almacen
    DB::table('almacenes')->insert([
      "nombre" => "Principal",
      "user_id" => 1,
      "created_at" => now(),
      "updated_at" => now(),
    ]);

    //Inventario
    DB::table('inventarios')->insert([
      "producto_id" => 1,
      "almacen_id" => 1,
      "cantidad" => 100,
      "created_at" => now(),
      "updated_at" => now(),
    ]);

    // Tipo de cambio
    DB::table('tipos_cambio')->insert([
      "moneda_id" => 2,
      "tipo_cambio_compra" => 3.5,
      "tipo_cambio_venta" => 3.6,
      "proveniente" => 1,
      "created_at" => now(),
      "updated_at" => now(),
    ]);

    DB::table('tipos_cambio')->insert([
      "moneda_id" => 2,
      "tipo_cambio_compra" => 3.7,
      "tipo_cambio_venta" => 3.7,
      "proveniente" => 2,
      "created_at" => now(),
      "updated_at" => now(),
    ]);
  }
}
