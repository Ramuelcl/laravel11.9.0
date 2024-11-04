<?php

namespace App\Livewire\Pages;

use Livewire\Component;

class Contacto extends Component
{
  public $name, $email;

  public function render()
  {
    return view('livewire.pages.contacto')
      ->layout('layouts.app', [
        'header' => 'Contactar con Nosotros'
      ]);
  }
}
