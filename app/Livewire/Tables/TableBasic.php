<?php
// app\Livewire\Tables\TableBasic.php

namespace App\Livewire\Tables;

use Livewire\Component;
use Livewire\WithPagination;

class TableBasic extends Component
{
  use WithPagination;

  public $datas;
  public $perPage ;

  public function mount($model, $filters=[], $fields, $perPage=10)
  { 
    $query = app($model)::query();

    foreach ($filters as $column => $value) {
        if ($value !== null) {
            $query->where($column, $value);
        }
    }
    $this->datas = $query->paginate($this->perPage);
  }

  public function render()
  { 
    $datas = $this->datas;
      return view('livewire.tables.table-basic',compact('datas'));
  }
}