<?php
// <!-- app/livewire/forms/menus.php -->

namespace App\Livewire\Forms;

use App\Models\backend\Tabla as Datos;
use Livewire\Component;

class Menus extends Component
{
  public $menus = [];
  public $nivel = 0;
  public $submenus;

  public function mount($parentId = 10000)
  {
    $t = new Datos();
    $this->menus = $t->getMenuData($parentId); // Obtener todos los elementos del menú
    dd($this->menus);
  }
  public function render()
  {
    return view('livewire.forms.menus');
  }
}
