<?php

namespace App\Http\Controllers;

use App\Imports\TraspasoBancaImport;
use App\Models\banca\TraspasoBanca;
use Illuminate\Http\Request;
use App\Imports\clsFileReader;

// use Maatwebsite\Excel\Facades\Excel;

class ImportExportController extends Controller
{
    public function showImportForm()
    {
        return view('banca.import');
    }

    public function import(Request $request)
    {
        $separadorCampos = $request->input('separador_campos');
        $caracterString = $request->input('caracter_string');
        $saltosLinea = $request->input('saltos_linea');
        $lineaDatos = $request->input('linea_datos');

        // Obtener los archivos enviados desde el formulario
        $archivos = $request->file('archivo');
        foreach ($archivos as $archivo) {

            // dump($archivo);
            // Obtener el nombre original del archivo
            $nombreOriginal = $archivo->getClientOriginalName();
            $extension = $archivo->getClientOriginalExtension();

            // Verificar si el archivo ya ha sido importado
            if ($this->checkFileImported($nombreOriginal)) {
                // El archivo ya ha sido importado, realiza alguna acción (por ejemplo, mostrar un mensaje de error)
                dump($archivo);
                // continue;
                // return redirect()->back()->with('error', 'El archivo ya ha sido importado');
            } else {
                // dump($archivo);
                // Procede con la importación del archivo
                try {
                    // para revisar las lineas desde el origen
                    // $import = new TraspasoBancaImport();
                    // $data = Excel::import($import, $archivo);

                    // $rows = $data[0]; // Obtener las filas del archivo
                    // dd(['data' => $data, 'rows' => $rows]);





                    // Importar el archivo
                    $import = new TraspasoBancaImport($separadorCampos, $caracterString, $saltosLinea, $lineaDatos, $nombreOriginal, $extension);
                    Excel::import($import, $archivo);




                    return redirect()->back()->with('success', 'El archivo se ha importado correctamente.');
                } catch (\Exception $e) {
                    // dd($archivo, $e->getMessage());
                    return redirect()->back()->with('error', 'Ha ocurrido un error al importar el archivo: ' . $e->getMessage());
                }
            }
        }
    }

    public function checkFileImported($nombreArchivo)
    {
        try {
            $count = TraspasoBanca::where('NomArchTras', $nombreArchivo)->count();
        } catch (\Throwable $th) {
            $count = 0;
        }

        return $count > 0;
    }
}
