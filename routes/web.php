<?php
// routes/web.php
use App\Http\Controllers\banca\TraspasoBancaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Livewire\Pages\Contacto;
use App\Livewire\Pruebas;
use Illuminate\Support\Facades\Route;

Route::get('/import', function () {
    return view('import');
});
Route::post('/import', [TraspasoBancaController::class, 'import'])->name('traspaso-banca.import');

// Route::get('/test-messages', function () {
//   // Establecer diferentes tipos de mensajes de sesión para probar el componente
//   session()->flash('success', 'Operación realizada con éxito.');
//   session()->flash('info', 'Este es un mensaje informativo.');
//   session()->flash('danger', 'Hubo un error al realizar la operación.');
//   session()->flash('warning', 'Hay un problema al realizar la operación.');

//   return view('test'); // Aquí usamos una vista de prueba
// });
// sistema BANCA
Route::group(['prefix' => 'banca'], function () {
    Route::get('/traspasos', [ImportExportController::class, 'showImportForm'])->name('banca.showImportForm');
    Route::get('/clientes', [ImportExportController::class, 'clientes'])->name('banca.clientes');
    Route::post('/traspasos/duplicados', [ImportExportController::class, 'eliminarRegistrosDuplicados'])->name('banca.eliminar.duplicados');
    Route::post('/traspasos/movimientos', [ImportExportController::class, 'TraspasoAMovimientos'])->name('banca.crearMovimientos');
});
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
// 
// para cargar DESDE menu y submenu
// Route::controller(ProfileController::class)->group(function () {
//   Route::get('/profile', 'index')->name('profile'); // Ruta principal de perfil
//   Route::get('/profile/edit', 'edit')->name('profile.edit'); // Ruta para editar el perfil
//   Route::patch('/profile/update', 'update')->name('profile.update'); // Ruta para actualizar el perfil
//   Route::delete('/profile/destroy', 'destroy')->name('profile.destroy'); // Ruta para eliminar el perfil
//   Route::get('/profile/password', 'edit')->name('profile.password'); // Ruta para cambiar contraseña
//   Route::get('/profile/privacy', 'edit')->name('profile.privacy'); // Ruta para cambiar privacidad
// });


require __DIR__ . '/auth.php';
// Include the routes from the trabajos.php file
// include __DIR__ . '/trabajos.php'; 