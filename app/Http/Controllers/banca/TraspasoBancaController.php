<?php

namespace App\Http\Controllers\banca;

use App\Http\Controllers\Controller;
use App\Imports\TraspasoBancaImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class TraspasoBancaController extends Controller
{
       public function import(Request $request)
    {
        // Validar que el archivo sea CSV o Excel
        $request->validate([
            'file' => 'required|mimes:csv,xlsx',
        ]);

        // Importar el archivo
        Excel::import(new TraspasoBancaImport, $request->file('file'));

        // Redirigir con un mensaje de éxito
        return back()->with('success', 'Datos importados correctamente.');
    }
}
