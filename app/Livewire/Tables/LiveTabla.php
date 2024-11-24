<?php
// app\Livewire\Tables\LiveTabla.php

namespace App\Livewire\Tables;

use Livewire\Component;
use Livewire\WithPagination;

class LiveTabla extends Component
{
    use WithPagination;

    public $data;
    public $encabezado;
    public $titulos;
    public $campos;
    public $lineasMostradas = 5;

    // Método para cargar más líneas
    public function mostrarMasLineas()
    {
        $this->lineasMostradas += 5;
    }

   // Método para el montaje inicial del componente
    public function mount($data, $encabezado, $titulos, $campos)
    {
        $this->data = $data;  // Asignamos los datos recibidos (todos los registros)
        $this->encabezado = $encabezado;
        $this->titulos = $titulos;
        $this->campos = $campos;
    }

    // Método para renderizar la vista
    public function render()
    {
        return view('livewire.tables.live-tabla', [
            'data' => $this->data,  // Pasamos los datos a la vista
        ]);
    }
}
