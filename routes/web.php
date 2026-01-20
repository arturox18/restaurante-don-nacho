<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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
Route::get('/mesero', function () {
    return view('mesero.dashboard');
})->middleware(['auth', 'verified'])->name('mesero.dashboard');

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

require __DIR__.'/auth.php';
