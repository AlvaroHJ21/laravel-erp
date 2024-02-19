<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\EntidadController;
use App\Http\Controllers\MonedaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\SerieController;
use App\Http\Controllers\TipoCambioController;
use App\Http\Controllers\TipoIgvController;
use App\Http\Controllers\UnidadController;
// use App\Http\Controllers\HomeController;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Auth::routes();


Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.login');
Route::get('/logout', [LoginController::class, 'logout'])->name('login.logout');

Route::middleware("auth")->group(function () {

    Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');
    /**
     * Empresa
     */
    Route::get("/configuracion/empresas", [EmpresaController::class, "index"])->name("empresas.index");
    Route::get("/configuracion/empresas/create", [EmpresaController::class, "create"])->name("empresas.create");
    Route::get("/configuracion/empresas/{empresa}/edit", [EmpresaController::class, "edit"])->name("empresas.edit");
    Route::post("/empresas", [EmpresaController::class, "store"])->name("empresas.store");
    Route::put("/empresas/{empresa}", [EmpresaController::class, "update"])->name("empresas.update");
    Route::put("/empresas/{empresa}/toggle-mode", [EmpresaController::class, "toggleMode"])->name("empresas.toggle_mode");
    Route::delete("/empresas/{empresa}", [EmpresaController::class, "destroy"])->name("empresas.destroy");

    /**
     * Entidades
     */
    Route::get("/entidades", [EntidadController::class, "index"])->name("entidades.index");
    Route::get("/entidades/create", [EntidadController::class, "create"])->name("entidades.create");
    Route::get("/entidades/{entidad}/edit", [EntidadController::class, "edit"])->name("entidades.edit");
    Route::post("/entidades", [EntidadController::class, "store"])->name("entidades.store");
    Route::put("/entidades/{entidad}", [EntidadController::class, "update"])->name("entidades.update");
    Route::delete("/entidades/{entidad}", [EntidadController::class, "destroy"])->name("entidades.destroy");

    /**
     * Series
     */
    Route::get("/configuracion/series", [SerieController::class, "index"])->name("series.index");
    Route::post("/series", [SerieController::class, "create"])->name("series.store");

    /**
     * Monedas
     */
    Route::get("/configuracion/monedas", [MonedaController::class, "index"])->name("monedas.index");
    Route::put("/monedas/{moneda}/change-status", [MonedaController::class, "changeStatus"])->name("monedas.change_status");

    /**
     * Tipos de cambio
     */
    Route::get("/configuracion/tipos-cambio", [TipoCambioController::class, "index"])->name("tipos_cambio.index");
    Route::post("/tipos-cambio", [TipoCambioController::class, "store"])->name("tipos_cambio.store");

    /**
     * Unidades
     */
    Route::get("/almacen/unidades", [UnidadController::class, "index"])->name("unidades.index");
    Route::put("/almacen/unidades/{unidad}/toggle-active", [UnidadController::class, "toggleActive"])->name("unidades.toggle_active");

    /**
     * Tipos de igv
     */
    Route::get("/almacen/tipos-igv", [TipoIgvController::class, "index"])->name("tipos_igv.index");
    Route::put("/almacen/tipos-igv/{tipo}/toggle-active", [TipoIgvController::class, "toggleActive"])->name("tipos_igv.toggle_active");

    /**
     * Categorias
     */
    Route::get("/almacen/categorias", [CategoriaController::class, "index"])->name("categorias.index");
    Route::post("/almacen/categorias", [CategoriaController::class, "store"])->name("categorias.store");
    Route::put("/almacen/categorias/{categoria}", [CategoriaController::class, "update"])->name("categorias.update");
    Route::put("/almacen/categorias/{categoria}/toggle-active", [CategoriaController::class, "toggleActive"])->name("categorias.toggle_active");

    /**
     * Productos
     */
    Route::get("/almacen/productos", [ProductoController::class, "index"])->name("productos.index");
    Route::get("/almacen/productos/create", [ProductoController::class, "create"])->name("productos.create");
    Route::get("/almacen/productos/{producto}/edit", [ProductoController::class, "edit"])->name("productos.edit");
    Route::post("/productos", [ProductoController::class, "store"])->name("productos.store");
    Route::put("/productos/{producto}", [ProductoController::class, "update"])->name("productos.update");
    Route::delete("/productos/{producto}", [ProductoController::class, "destroy"])->name("productos.destroy");
});
