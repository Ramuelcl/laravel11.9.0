<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;

use Illuminate\Support\Facades\Route;

Route::controller(HomeController::class)->group(function () {
  Route::get('/', 'welcome')->name('inicio'); // Blade
  Route::get('/acercade', 'acercaDe')->name('acercade'); // Blade
  Route::get('/contacto', 'contacto')->name('contacto'); // Blade
  Route::get('/iconos', 'iconos')->name('iconos'); // Blade
  Route::get('/ayuda', 'ayuda')->name('ayuda'); // Blade
});

// Route::get('/', function () {
//     return view('welcome');
// })->name('inicio');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
