<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminCocheController;
use App\Http\Controllers\AdminUsuarioController;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\ConcesionarioController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;

Route::get('/', [ConcesionarioController::class, 'index'])->name('home');
Route::get('/coches/{id}', [ConcesionarioController::class, 'show'])->name('coches.show');

Route::get('/registro', [LoginController::class, 'showRegisterForm'])->name('register');
Route::post('/registro', [LoginController::class, 'register'])->name('register.submit');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/perfil', [ProfileController::class, 'index'])->middleware('auth')->name('profile');
Route::put('/perfil/actualizar', [ProfileController::class, 'update'])->middleware('auth')->name('profile.update');

Route::get('/carrito', fn () => view('cart'))->name('cart');
Route::post('/carrito/add/{id}', [CarritoController::class, 'add'])->middleware('auth')->name('carrito.add');
Route::post('/carrito/comprar', [CarritoController::class, 'finalizarCompra'])->middleware('auth')->name('carrito.comprar');
Route::delete('/carrito/eliminar/{id}', [CarritoController::class, 'remove'])->name('carrito.remove');

Route::middleware(['auth', 'es_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/usuarios', [AdminUsuarioController::class, 'index'])->name('usuarios.index');
    Route::get('/usuarios/{id}/editar', [AdminUsuarioController::class, 'edit'])->name('usuarios.edit');
    Route::put('/usuarios/{id}', [AdminUsuarioController::class, 'update'])->name('usuarios.update');
    Route::delete('/usuarios/{id}', [AdminUsuarioController::class, 'destroy'])->name('usuarios.destroy');

    Route::get('/coches', [AdminCocheController::class, 'index'])->name('coches.index');
    Route::post('/coches', [AdminCocheController::class, 'store'])->name('coches.store');
    Route::put('/coches/{id}', [AdminCocheController::class, 'update'])->name('coches.update');
    Route::delete('/coches/{id}', [AdminCocheController::class, 'destroy'])->name('coches.destroy');
});
