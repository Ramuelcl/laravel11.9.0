<?php
// app/Livewire/Pruebas.php

namespace App\Livewire;

use Livewire\Component;

class Pruebas extends Component
{


  public $showWindowModal = false;
  public $showWindow = false;

  public function render()
  {
    // return view('livewire.pruebas');
    return view('livewire.pruebas')
      ->layout('layouts.app', [
        'header' => 'Pruebas'
      ]);
  }

  // Método para mostrar u ocultar el modal siempre modal
  public function toggleWindowModal()
  {
    $this->showWindowModal = !$this->showWindowModal;
  }

  // Método para mostrar u ocultar el contenedor no modal
  public function toggleWindow()
  {
    $this->showWindow = !$this->showWindow;
  }
}
