<?php

use App\Http\Controllers\EmpresaController;
use Illuminate\Support\Facades\Auth;
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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get("/empresas", [EmpresaController::class, "index"])->name("empresas.index");
Route::get("/empresas/create", [EmpresaController::class, "create"])->name("empresas.create");
Route::get("/empresas/{empresa}/edit", [EmpresaController::class, "edit"])->name("empresas.edit");
Route::post("/empresas", [EmpresaController::class, "store"])->name("empresas.store");
Route::put("/empresas/{empresa}", [EmpresaController::class, "update"])->name("empresas.update");
Route::put("/empresas/{empresa}/toggle-mode", [EmpresaController::class, "toggleMode"])->name("empresas.toggle_mode");
Route::delete("/empresas/{empresa}", [EmpresaController::class, "destroy"])->name("empresas.destroy");
