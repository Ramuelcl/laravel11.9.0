<?php
// routes/web.php
use App\Http\Controllers\banca\TraspasoBancaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Livewire\Pages\Contacto;
use App\Livewire\Pruebas;
use App\Livewire\Travail\Clientes;
use Illuminate\Support\Facades\Route;

// Route::get('/test-messages', function () {
//   // Establecer diferentes tipos de mensajes de sesión para probar el componente
//   session()->flash('success', 'Operación realizada con éxito.');
//   session()->flash('info', 'Este es un mensaje informativo.');
//   session()->flash('danger', 'Hubo un error al realizar la operación.');
//   session()->flash('warning', 'Hay un problema al realizar la operación.');

//   return view('test'); // Aquí usamos una vista de prueba
// });

// Sistema Travail
Route::middleware('auth')
    ->prefix('travail')
    ->controller(Clientes::class)
    ->group(function () {
        Route::get('/clientes', Clientes::class)->name('travail.clientes');
        Route::post('/clientes', Clientes::class)->name('travail.clientes');
    });

  // sistema BANCA
  Route::group(['prefix' => 'banca'], function () {
      Route::get('/traspasos', [TraspasoBancaController::class, 'showTable'])->name('banca.showTable');
      Route::get('/traspasos', [TraspasoBancaController::class, 'showImportForm'])->name('banca.showImportForm');
      Route::post('/traspasos', [TraspasoBancaController::class, 'import'])->name('banca.import');
      Route::post('/traspasos/duplicados', [TraspasoBancaController::class, 'eliminarRegistrosDuplicados'])->name('banca.eliminar.duplicados');
      Route::post('/traspasos/movimientos', [TraspasoBancaController::class, 'crearMovimientos'])->name('banca.crearMovimientos');
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/users', [ProfileController::class, 'destroy'])->name('users');
    Route::get('/users/index', [ProfileController::class, 'destroy'])->name('users.index');
    Route::get('/roles/index', [ProfileController::class, 'destroy'])->name('user.roles.index');
    Route::get('/roles/index', [ProfileController::class, 'destroy'])->name('roles.index');
    Route::get('/roles/create', [ProfileController::class, 'destroy'])->name('roles.create');
    Route::get('/roles/edit', [ProfileController::class, 'destroy'])->name('roles.edit');
    Route::get('/permisos/index', [ProfileController::class, 'destroy'])->name('permisos.index');
    Route::get('/permisos/create', [ProfileController::class, 'destroy'])->name('permisos.create');
    Route::get('/permisos/edit', [ProfileController::class, 'destroy'])->name('permisos.edit');
    Route::get('user/permis/index', [ProfileController::class, 'destroy'])->name('user.permis.index');
});

require __DIR__.'/auth.php';
