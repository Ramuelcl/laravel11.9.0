<?php

namespace App\Livewire\Tables;

use App\Models\banca\Traspaso;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class TableTraspasos extends Component
{
      use WithPagination;

    public function render()
    {
        return view('livewire.tables.table-traspasos', [

'data' => Traspaso::orderBy(DB::raw("STR_TO_DATE(date, '%d/%m/%Y')"), 'desc')->paginate(10),

            // 'data' => Traspaso::latest()->paginate(10),
        ]);
    }
}