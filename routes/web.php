<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\MesaController;
use App\Http\Controllers\MeseroController;
use App\Http\Controllers\CocineroController;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/mi-perfil', function () {
        return view('profile.show');
    })->name('profile.show');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/historial', [AdminController::class, 'historial'])->name('historial');


    //  ÁREA ADMINISTRATIVA
    Route::prefix('usuarios')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('users.index');
        Route::get('/crear', [UserController::class, 'create'])->name('users.create');
        Route::post('/crear', [UserController::class, 'store'])->name('users.store');
        Route::patch('/{user}/rol', [UserController::class, 'updateRole'])->name('users.updateRole');
        Route::patch('/{user}/status', [UserController::class, 'toggleStatus'])->name('users.toggleStatus');
    });

    // 2. Gestión del Menú
    Route::prefix('menu')->group(function () {
        Route::get('/', [MenuController::class, 'index'])->name('menu.index');
        Route::get('/crear', [MenuController::class, 'create'])->name('menu.create');
        Route::post('/', [MenuController::class, 'store'])->name('menu.store');
        Route::get('/{producto}/editar', [MenuController::class, 'edit'])->name('menu.edit');
        Route::put('/{producto}', [MenuController::class, 'update'])->name('menu.update');
        Route::delete('/{producto}', [MenuController::class, 'destroy'])->name('menu.destroy');
        Route::patch('/{producto}/status', [MenuController::class, 'toggleStatus'])->name('menu.toggleStatus');
    });

    // 3. Gestión de Categorías
    Route::get('/categorias/crear', [CategoriaController::class, 'create'])->name('categorias.create');
    Route::post('/categorias', [CategoriaController::class, 'store'])->name('categorias.store');
    Route::prefix('admin/mesas')->group(function () {
        Route::get('/', [MesaController::class, 'index'])->name('mesas.index');
        Route::post('/', [MesaController::class, 'store'])->name('mesas.store');
        Route::delete('/{mesa}', [MesaController::class, 'destroy'])->name('mesas.destroy');
    });


    //  ÁREA DEL MESERO
    Route::get('/mesero', [MeseroController::class, 'index'])->name('mesero.dashboard');
    Route::get('/mesero/mis-ordenes', [MeseroController::class, 'misOrdenes'])->name('mesero.ordenes');
    Route::get('/mesero/historial', [MeseroController::class, 'historial'])->name('mesero.historial');
    Route::prefix('mesas/{mesa}')->group(function () {
        Route::get('/menu', [MeseroController::class, 'catalogo'])->name('mesero.catalogo');
        Route::get('/categoria/{categoria}', [MeseroController::class, 'platillos'])->name('mesero.platillos');
        Route::get('/platillo/{producto}', [MeseroController::class, 'detalle'])->name('mesero.detalle');
        Route::post('/platillo/{producto}', [MeseroController::class, 'agregar'])->name('mesero.agregar');
        Route::get('/carrito', [MeseroController::class, 'carrito'])->name('mesero.carrito');
        Route::post('/confirmar', [MeseroController::class, 'confirmarOrden'])->name('mesero.confirmar');
        Route::get('/ticket', [MeseroController::class, 'ticket'])->name('mesero.ticket');
    });

    //  ÁREA DE COCINA
    Route::get('/cocina', [CocineroController::class, 'index'])->name('cocinero.dashboard');
    Route::get('/cocina/{orden}/ticket', [CocineroController::class, 'ticketCocina'])->name('cocinero.ticket');
    Route::patch('/cocina/{orden}/terminar', [CocineroController::class, 'terminarOrden'])->name('cocinero.terminar');
    Route::get('/cocina/historial', [CocineroController::class, 'historial'])->name('cocinero.historial');
});

require __DIR__ . '/auth.php';
