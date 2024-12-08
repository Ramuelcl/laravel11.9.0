<?php
// app/livewire/travail/clientes.php

namespace App\Livewire\Travail;

use App\Models\backend\Categoria;
use App\Models\backend\Entidad;
use App\Models\backend\Marcador;
use App\Models\backend\Tabla;
use Livewire\Component;
use Livewire\WithPagination;

class Clientes extends Component
{
  use WithPagination;
  
  public $model = Entidad::class;
  public $datas;
  public $filters = ['tipoEntidad' => '2'];
  public $perPage = 10; 

  public $accion = "crear";
  public $open = false; // intercambia entre listado y formulario de alta/baja/edicion

  public $nombres, $apellidos, $tipoEntidad, $razonSocial, $website, $titulo, $image_path, $categoria_id, $marcadores_id=[], $colores=[];
  public $is_active;
  public $aniversario;
  public $sexo;
  public $tiposEntidad = [], $categorias = [], $marcadores = [];
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
    $t = new Tabla();
    $this->tiposEntidad = $t->qTablas(config('constantes.TIPO_DATOS'));
    $this->categorias = Categoria::getActiveCategories()->toArray();
    $this->marcadores = Marcador::getActiveMarcadores( )->take(10)->toArray();
    $this->colores = Marcador::getActiveColores( )->take(10)->toArray();
    // $this->categorias =[1=>'uno', 2=>'dos', 3=>'tres', 4=>'cuatro', 5=>'cinco'];
    dd($this->marcadores, $this->colores);
    // $this->categorias = $query->get()->toArray();
    // $this->marcadores = Marcador::where('is_active', true)->get(['nombre', 'id', 'hexa'])->toArray();

    foreach($this->filters as $key => $filter){
      $this->datas = $this->datas->where($key, $filter);
    }
    // dd($this->tiposEntidad, $this->datas);
    // dd($this->datas->toArray());
    // $this->datas = $this->datas->paginate($this->perPage);
    }

  public function render()
  {
      return view('livewire.travail.clientes'); 
      //, 'tiposEntidad' => $this->tiposEntidad, 'fields' => $this->fields
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


    public function crear($data)
    {
            dd('crear');
        // Lógica para crear un cliente
    }

    public function editar($id, $data)
    {      
      dd('editar');
        // Lógica para editar un cliente
    }

    public function eliminar($id)
    {
      dd('eliminar');
        // Lógica para eliminar un cliente
    }

    public function save($id)
    {
      dd('save');
        // Lógica para eliminar un cliente
    }

}
