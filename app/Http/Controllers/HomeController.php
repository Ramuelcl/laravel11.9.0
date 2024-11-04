<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
  // Página de entrada al sistema
  public function welcome()
  {
    return view('pages.welcome');
    // return view('livewire.welcome'); // Asumiendo que existe un componente Livewire 'entrada'
  }

  // Página "Acerca de" (Blade)
  public function acercaDe()
  {
    return view('pages.acercade'); // Asumiendo que existe una vista Blade 'acercade' en 'resources/views/pages'
  }

  // Página "Ayuda" (Blade)
  public function iconos()
  {
    return view('pages.iconos'); // Vista Blade para 'iconos'
  }

  // Página "todo" (Blade)
  public function pruebas()
  {
    return view('pages.pruebas'); // Vista Blade para 'todo'
  }
}
