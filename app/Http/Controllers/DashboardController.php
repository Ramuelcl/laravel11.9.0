<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
  // Página de entrada al sistema
  public function index()
  {
    return view('dashboard.index');
    // return view('livewire.welcome'); // Asumiendo que existe un componente Livewire 'entrada'
  }

}
