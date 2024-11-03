<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
  // Página de entrada al sistema (Livewire)
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

  // Página "Contactarnos" (Livewire)
  public function contactarnos()
  {
    return view('livewire.contactarnos'); // Componente Livewire para 'contactarnos'
  }

  // Página "Ayuda" (Blade)
  public function ayuda()
  {
    return view('pages.ayuda'); // Vista Blade para 'ayuda'
  }
}
