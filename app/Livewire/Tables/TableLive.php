<?php
// app\Livewire\Tables\LiveTabla.php

namespace App\Livewire\Tables;

use Livewire\Component;
use Livewire\WithPagination;

class TableLive extends Component
{
    use WithPagination;

    public $model;    // Nombre del modelo
    public $filters;  // Filtros opcionales
    public $data;
    public $fields;
    public $titles;
    public $perPage;  // Elementos por página
    
    // Método para el montaje inicial del componente
    public function mount($model, $fields, $filters = [], $perPage = 10)
    {
        $this->model = $model;       // Nombre del modelo
        // $this->fields = $this->normalizeFields($fields);
        $this->filters = $filters;  // Filtros opcionales
        $this->titles = $this->theTitles($fields);
        $this->fields = $this->theFields($fields);
        // dd($this->titles, $this->fields);
        $this->perPage = $perPage;  // Elementos por página
    }

    // Método para renderizar la vista
    public function render() {
      $query = app($this->model)::query();
      $paginatedData = $query->paginate($this->perPage);

    // Proceso para preparar los campos que serán usados en la vista
    // $processedFields = collect($this->fields)->filter(fn($field) => $field['list']['display'])->map(function ($field, $id) {
    //     return [
    //         'id' => $id,
    //         'title' => $field['title'],
    //         'type' => $field['type'],
    //         'options' => $field['list']['options'] ?? null,
    //     ];
    // });

    // dd($paginatedData->toArray());
    return view('livewire.tables.table-live', [
        'data' => $paginatedData,
        'fields' => $this->fields,
    ]);
    }

  private function theTitles($fields){
    return collect($fields)
      ->filter(fn($field) => $field['list'] ?? false) // Solo campos visibles
      ->mapWithKeys(fn($field, $key) => [$key => $field['title'] ?? $key])
      ->toArray();
  }
  
  public function getField($field, $prop){
    return $this->fields[$field][$prop] ?? null;
  }
  private function theFields($fields)
{
    $filteredFields = [];

    foreach ($fields as $id => $field) {
        // Validar que el campo tenga 'list' definido y que su 'display' sea true
        if (isset($field['list']['display']) && $field['list']['display']) {
            // Agregar solo las claves relevantes (sin incluir 'form')
            $filteredFields[$id] = [
                'title' => $field['title'],
                'type' => $field['type'],
                'default' => $field['default'],
            ];
        }
    }

    return $filteredFields;
}

}
