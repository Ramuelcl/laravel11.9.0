<?php

namespace App\Http\Controllers\travail;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TravailController extends Controller
{
    public function clientes()
    {
        return view('livewire.travail.clientes');
    }

    public function crear()
    {
        return view('livewire.travail.clientes-form');
    }

    public function editar()
    {
        return view('livewire.travail.clientes-form');
    }

    public function eliminar()
    {
        return view('livewire.travail.clientes-form');
    }
}
