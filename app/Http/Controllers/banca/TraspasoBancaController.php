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
        'marcador1' => 'required|string',
        // 'marcador2' => 'string',
      ]);
      
      // Reiniciar índice si la tabla está vacía
      $this->resetAutoIncrementIfTableEmpty('traspasosBanca');
      
      $marcador1 = $request->input('marcador1'); // Captura el marcador1
      // $marcador2 = $request->input('marcador2'); // Captura el marcador2
      
      foreach ($request->file('archivo') as $archivo) {
        $this->processFile($archivo, $marcador1);//,$marcador2
      }
      // dump('paso 1');
      return redirect()->back()->with('success', 'Archivos importados correctamente.');
    }

    public function crearMovimientos()
    {
      // dd('paso 2');

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
          'francs' => 0,
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

private function processFile($archivo, $marcador1)//, $marcador2
{
    $nombre = $archivo->getClientOriginalName();
    $ext = $archivo->getClientOriginalExtension();
    $delimitador = $ext === 'csv' ? ',' : ($ext === 'tsv' ? "\t" : ';');

    // Abrir el archivo para lectura
    $file = fopen($archivo, 'r');
    if (!$file) {
        Log::error("No se pudo abrir el archivo: $nombre");
        return redirect()->back()->withErrors(['archivo' => "No se pudo abrir el archivo: $nombre"]);
    }

    $leerDatos = false;

    // Procesar cada línea del archivo
    while (($line = fgetcsv($file, 0, $delimitador)) !== false) {

      // Convertir la línea a texto para buscar el marcador1
        $lineaTexto = implode($delimitador, $line);
        // Comienza a leer datos después del marcador1
        if (!$leerDatos && str_contains($lineaTexto, $marcador1)) {
          $leerDatos = true;
          continue; // Salta la línea del marcador1
        }
        // dump($line);
        // dump(['leyendo archivo'=>$lineaTexto, 'leerDatos'=>$leerDatos,'contieneMarcador'=>str_contains($lineaTexto, $marcador1)]);
        // Si aún no hemos encontrado el marcador1, continúa al siguiente ciclo
        if (!$leerDatos) {
          continue;
        }

        // Validar la estructura de la línea
        if (count($line) < 3) { // Asegúrate de tener al menos tres columnas
            Log::warning("Línea mal formateada en el archivo $nombre: " . implode($delimitador, $line));
            continue;
        }

        try {
            // Procesar el campo "Libelle" para asegurarnos de que sea válido
            $libelle = $line[1];
            if (!mb_check_encoding($libelle, 'UTF-8')) {
                $libelle = utf8_encode($libelle); // Convertir a UTF-8
            }
            $libelle = preg_replace('/[^\x20-\x7E]/', '', $libelle); // Remover caracteres no válidos

            // Crear o actualizar registros en la tabla `traspasos`
            Traspaso::updateOrCreate(
                [
                    'Date' => $line[0], // Fecha
                    'Libelle' => $libelle, // Descripción
                    'MontantEUROS' => $line[2], // Monto en euros
                    'MontantFRANCS' => $line[3] ?? 0, // Monto en euros
                ],
                [
                    'NomArchTras' => $nombre // Nombre del archivo
                ]
            );
        } catch (\Exception $e) {
            Log::error("Error al procesar la línea en el archivo $nombre: " . $e->getMessage());
            continue; // Continuar con la siguiente línea si ocurre un error
        }
      }
      fclose($file); // Cerrar el archivo al terminar
      // dd('stop');
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
