<?php

namespace App\Livewire\Forms;

use App\Models\backend\Tabla as Datos;
use Livewire\Component;

class Menus extends Component
{
  public $menus = [];
  public $tablaId;

  public function mount($tablaId = 10000)
  {
    $this->tablaId = $tablaId;
    $this->loadMenus();
  }

  public function loadMenus()
  {
    $tablaModel = new Datos();
    $this->menus = $tablaModel->getMenu($this->tablaId);
  }

  public function render()
  {
    return view('livewire.forms.menus', [
      'menus' => $this->menus,
    ]);
  }
}
