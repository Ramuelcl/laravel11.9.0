<?php
// routes/web.php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Livewire\Pages\Contacto;
use App\Livewire\Pruebas;
use Illuminate\Support\Facades\Route;

// Route::get('/test-messages', function () {
//   // Establecer diferentes tipos de mensajes de sesión para probar el componente
//   session()->flash('success', 'Operación realizada con éxito.');
//   session()->flash('info', 'Este es un mensaje informativo.');
//   session()->flash('danger', 'Hubo un error al realizar la operación.');
//   session()->flash('warning', 'Hay un problema al realizar la operación.');

//   return view('test'); // Aquí usamos una vista de prueba
// });

Route::controller(HomeController::class)->group(function () {
  Route::get('/', 'welcome')->name('inicio'); // Blade
  Route::get('/acercade', 'acercaDe')->name('acercade'); // Blade
  // Route::get('/contacto', 'contacto')->name('contacto'); // livewire
  Route::get('/iconos', 'iconos')->name('iconos'); // Blade
  Route::get('/pruebas', 'pruebas')->name('pruebas'); // Blade
});
// Ruta para el componente Livewire
Route::get('/contacto', Contacto::class)->name('contacto');

Route::get('/pruebas', Pruebas::class)->name('pruebas');
Route::get('/blog', Pruebas::class)->name('blog');
Route::get('/portfolio', Pruebas::class)->name('portfolio');


// Route::get('/', function () {
//     return view('welcome');
// })->name('inicio');

Route::get('/dashboard', function () {
  return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
  Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
  Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
  Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
// Include the routes from the trabajos.php file
// include __DIR__ . '/trabajos.php'; 