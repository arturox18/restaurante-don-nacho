<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\MesaController;
use App\Http\Controllers\MeseroController;

#Route::get('/', function () {
#    return view('welcome');
#});

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/usuarios', [UserController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('users.index');

// Formulario para crear usuario
Route::get('/registrar-usuarios', [UserController::class, 'create'])
    ->middleware(['auth', 'verified'])
    ->name('users.create');

// Guardar el usuario en la base de datos
Route::post('/registrar-usuarios', [UserController::class, 'store'])
    ->middleware(['auth', 'verified'])
    ->name('users.store');

// --- RUTA DEL MESERO ---
// Usa el controlador que sí trae las mesas
Route::get('/mesero', [App\Http\Controllers\MeseroController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('mesero.dashboard');

// --- RUTA DEL COCINERO ---
Route::get('/cocina', function () {
    return view('cocinero.dashboard');
})->middleware(['auth', 'verified'])->name('cocinero.dashboard');

// Ruta para VER el perfil (la tarjeta bonita)
Route::get('/mi-perfil', function () {
    return view('profile.show');
})->middleware(['auth', 'verified'])->name('profile.show');

// Cambiar Rol
Route::patch('/usuarios/{user}/rol', [UserController::class, 'updateRole'])
    ->middleware(['auth', 'verified'])
    ->name('users.updateRole');

// Activar / Desactivar
Route::patch('/usuarios/{user}/status', [UserController::class, 'toggleStatus'])
    ->middleware(['auth', 'verified'])
    ->name('users.toggleStatus');

Route::patch('/usuarios/{user}/status', [UserController::class, 'toggleStatus'])
    ->middleware(['auth', 'verified'])
    ->name('users.toggleStatus');

// Rutas del Menú
Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
Route::get('/menu/{producto}/editar', [MenuController::class, 'edit'])->name('menu.edit');
Route::put('/menu/{producto}', [MenuController::class, 'update'])->name('menu.update');
Route::patch('/menu/{producto}/status', [MenuController::class, 'toggleStatus'])->name('menu.toggleStatus');

Route::get('/menu/crear', [MenuController::class, 'create'])->name('menu.create');
Route::post('/menu', [MenuController::class, 'store'])->name('menu.store');

// Rutas del Mesero
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/mesas', [MeseroController::class, 'index'])->name('mesero.dashboard');
    Route::get('/mesas/{mesa}/menu', [MeseroController::class, 'catalogo'])->name('mesero.catalogo');
    Route::get('/mesas/{mesa}/categoria/{categoria}', [MeseroController::class, 'platillos'])->name('mesero.platillos');
    Route::get('/mesas/{mesa}/platillo/{producto}', [MeseroController::class, 'detalle'])->name('mesero.detalle');
    Route::post('/mesas/{mesa}/platillo/{producto}', [MeseroController::class, 'agregar'])->name('mesero.agregar');
    Route::get('/mesas/{mesa}/carrito', [MeseroController::class, 'carrito'])->name('mesero.carrito');
    Route::post('/mesas/{mesa}/confirmar', [MeseroController::class, 'confirmarOrden'])->name('mesero.confirmar');
});

// Rutas para Administrar Mesas
Route::get('/admin/mesas', [MesaController::class, 'index'])->name('mesas.index');
Route::post('/admin/mesas', [MesaController::class, 'store'])->name('mesas.store');
Route::delete('/admin/mesas/{mesa}', [MesaController::class, 'destroy'])->name('mesas.destroy');

require __DIR__ . '/auth.php';
