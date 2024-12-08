<?php
// app/livewire/travail/clientes.php

namespace App\Livewire\Travail;

use App\Models\backend\Entidad;
use Livewire\Component;
use Livewire\WithPagination;

class Clientes extends Component
{
  use WithPagination;
  
  public $model = Entidad::class;
  public $datas;
  public $filters = ['tipoEntidad' => '2'];
  public $perPage = 10; 

  public $open = true; // intercambia entre listado y formulario de alta/baja/edicion

  public $fields = [
    'tipoEntidad' => [
      'title'=>'Tipo',
      'type'=>'string',
      'default'=>'2',
      'form'=>[
        'display' =>false,
      ],
      'list'=>[
        'display' =>false,
      ],
    ],
    'nombres'=> [
      'title'=>'Nombres',
      'type'=>'string',
      'form'=>[
        'display' =>true,
        'rules'=>'required|min:3',
      ],
      'list'=>[
        'display' =>true,
      ],
    ],
    'apellidos'=>[
      'title'=>'Apellidos',
      'type'=>'string',
      'form'=>[
        'display' =>true,
        'rules'=>'required|min:3',
      ],
      'list'=>[
        'display' =>true,
      ],
    ],
    'is_active'=>[
      'title'=>'Activo',
      'type'=>'boolean',
      'form'=>[
        'display' =>true,
        'rules'=>'required|min:3',
      ],
      'list'=>[
        'display' =>true,
        'options' => ['yes', 'no'],
      ],
      ],
    'aniversario'=>[
      'title'=>'Aniversario',
      'type'=>'date',
      'form'=>[
        'display' =>true,
        'rules'=>'required|date:Y-m-d',
      ],
      'list'=>[
        'display' =>true,
      ],
    ],
    'sexo'  =>[
      'title'=>'Sexo',
      'type'=>'checkit',
      'form'=>[
        'display' =>true,
        'rules'=>'required',
      ],
      'list'=>[
        'display' =>true,
        'options' => ['man', 'woman'],
      ],
    ],
  ]; 

  public function mount(){
    $this->fields = $this->normalizeFields($this->fields);
    $this->datas = Entidad::all();
    foreach($this->filters as $key => $filter){
      $this->datas = $this->datas->where($key, $filter);
    }
    // dd($this->datas->toArray());
    // $this->datas = $this->datas->paginate($this->perPage);
    }

  public function render()
  {
      return view('livewire.travail.clientes', ['datas' => $this->datas]);
  }

  private function normalizeFields($fields) {
    $defaults = [
      'title' => '',
      'type' => 'string',
      'default' => null,
      'form' => [
        'display' =>false,
        'rules' =>null,
      ],
      'list' => [
        'display' =>false,
        'options' => [], 
      ],
    ];
    return collect($fields)
      ->mapWithKeys(function ($field, $key) use ($defaults) {
        // Si el campo no es un arreglo, inicializarlo como un arreglo vacío
        if (!is_array($field)) {
            $field = [];
        }

        // Combinar el arreglo con los valores predeterminados
        $normalizedField = array_merge($defaults, $field);

        return [$key => $normalizedField];
      })
      ->toArray();
    }
}
