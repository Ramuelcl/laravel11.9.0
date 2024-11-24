<?php

namespace App\Http\Controllers\banca;

use App\Http\Controllers\Controller;
use App\Models\banca\Movimiento;
use App\Models\banca\Traspaso;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Log;

class TraspasoBancaController extends Controller
{    
  public $totalPendientes;
  protected $listeners = ['cuentaTraspasos' => 'cuentaTraspasos',
  'cuentaMovimientos' => 'cuentaMovimientos'];

  public function cuentaTraspasos(){
    return Traspaso::count();
  }
  public function cuentaMovimientos(){
    return $this->totalPendientes--;
  }

    public function showImportForm()
    {
        $data = Traspaso::latest()->get();
        $titulos = [ // Encabezados de la tabla
        'ID', 'Fecha', 'Descripción', 'Euros', 'Francos', 'Archivo', 'ID Movimiento'
    ]; 

    $campos = [
        'id', 'date', 'libelle', 'montantEUROS', 'montantFRANCS', 'NomArchTras', 'idArchMov'
    ]; // Correspondencia con los campos en la base de datos.
    $totalPendientes = Traspaso::whereNull('idArchMov')->count();

    return view('banca.traspasoBanca', [
        'data' => $data,
        'titulos' => $titulos,
        'campos' => $campos,
        'totalImportados' => Traspaso::count(),
        'totalDuplicados' => $this->countDuplicates(),
        'totalMovimientos' => Movimiento::count(),
        'totalPendientes' => $this->totalPendientes,
    ]);
    }

    public function import(Request $request)
    {
      Log::info('Formulario procesado:', $request->all());
      
      $request->validate([
        'archivo' => 'required|array',
        'archivo.*' => 'file|mimes:csv,txt,tsv|max:2048',
        'marcador' => 'required|string',
      ]);
      // Reiniciar índice si la tabla está vacía
      $this->resetAutoIncrementIfTableEmpty('traspasosBanca');
      
      $marcador = $request->input('marcador'); // Captura el marcador
      
      foreach ($request->file('archivo') as $archivo) {
        $this->processFile($archivo, $marcador);
      }
      $this->crearMovimientos();
      dump('paso 1');
      return redirect()->back()->with('success', 'Archivos importados correctamente.');
    }

    public function crearMovimientos()
    {
      dd('paso 2');

      $traspasos = Traspaso::whereNull('idArchMov')->get();
      // dd(count($traspasos));
      $this->totalPendientes  = Traspaso::whereNull('idArchMov')->count();

      foreach ($traspasos as $traspaso) {
        try {
          // Especifica el formato en el que viene la fecha
          $date = Carbon::createFromFormat('d/m/Y', $traspaso->date);

          // Si necesitas formatearlo para la base de datos (formato Y-m-d)
          $formattedDate = $date->format('Y-m-d');

          echo $formattedDate; // Salida: 2012-12-31
        } catch (\Exception $e) {
          // Manejo del error si el formato es incorrecto
          echo "Error al convertir la fecha: " . $e->getMessage();
        }
        // Reemplaza la coma (si existe) por un vacío para manejar el formato
        $decimalString = str_replace(',', '', $traspaso->montantEUROS);

        // Convierte a float
        $decimal = floatval($decimalString);

        echo $decimal; // Salida: 1234.56
        // Crear un nuevo registro de movimiento
        $movimiento = new Movimiento([
          'dateMouvement' => $formattedDate,
          'libelle' => $traspaso->libelle,
          'montant' => $decimal,
          'estado' => 1,
        ]);
        $movimiento->save();
        // Actualizar idArchMov del traspaso
        $traspaso->idArchMov = $movimiento->id;
        $this->totalPendientes--;
        $traspaso->update(['idArchMov' => $movimiento->id]);
      }
      // $this->dispatch('cuentaMovimientos'); 
      // session()->flash('success', 'Registros movidos a movimientos correctamente.');

      return redirect()->back();
    }

  private function processFile($archivo, $marcador)
  {
    $nombre = $archivo->getClientOriginalName();
    $ext = $archivo->getClientOriginalExtension();
    $delimitador = $ext === 'csv' ? ',' : ($ext === 'tsv' ? "\t" : ';');
  
    $file = fopen($archivo, 'r');
    $leerDatos = false;

    while (($line = fgetcsv($file, 0, $delimitador)) !== false) {
        $lineaTexto = implode($delimitador, $line);

        if (!$leerDatos && str_contains($lineaTexto, $marcador)) {
            $leerDatos = true;
            continue;
        }

        if ($leerDatos) {
            // Limpieza de caracteres no válidos
            $libelle = $line[1];
            if (!mb_check_encoding($libelle, 'UTF-8')) {
                $libelle = mb_convert_encoding($libelle, 'UTF-8', 'ISO-8859-1');
            }
            $libelle = preg_replace('/[^\x20-\x7E]/', '', $libelle);

            Traspaso::updateOrCreate(
                ['Date' => $line[0], 
                'Libelle' => $libelle, 
                'MontantEUROS' => $line[2]],
                ['NomArchTras' => $nombre]
            );
        }
    }

    fclose($file);
    }
    
    public function removeDuplicates()
    {
        $duplicates = $this->findDuplicates();
        foreach ($duplicates as $duplicate) {
            Traspaso::where('id', '<>', $duplicate->min_id)
                ->whereRaw('CONCAT(Date, Libelle, MontantEUROS) = ?', [$duplicate->concatFields])
                ->delete();
        }
        return redirect()->back()->with('success', 'Registros duplicados eliminados.');
    }

    private function countDuplicates()
    {
        return Traspaso::selectRaw('CONCAT(Date, Libelle, MontantEUROS) as concatFields, COUNT(*) as count')
            ->groupBy('concatFields')
            ->having('count', '>', 1)
            ->count();
    }

    private function findDuplicates()
    {
        return Traspaso::selectRaw('MIN(id) as min_id, CONCAT(Date, Libelle, MontantEUROS) as concatFields')
            ->groupBy('concatFields')
            ->havingRaw('COUNT(*) > 1')
            ->get();
    }
    
    private function resetAutoIncrementIfTableEmpty($tableName)
    {
      $count = DB::table($tableName)->count();

      if ($count === 0) {
          DB::statement("ALTER TABLE $tableName AUTO_INCREMENT = 1");
      }
    }

    public function removeAll()
    {
      DB::table('traspasosBanca')->truncate(); // Vacía la tabla
      $this->resetAutoIncrementIfTableEmpty('traspasosBanca');

      return redirect()->back()->with('success', 'Todos los registros han sido eliminados y el índice reiniciado.');
    }

}
