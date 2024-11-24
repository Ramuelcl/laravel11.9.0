<?php

namespace App\Http\Controllers;

use App\Imports\TraspasoBancaImport;
use App\Models\backend\Ciudad;
use App\Models\backend\Direccion;
use App\Models\backend\Entidad;
use App\Models\backend\Pais;
use App\Models\backend\Telefono;
use App\Models\banca\Client;
use App\Models\banca\Movimiento;
use App\Models\banca\Traspaso;
use Carbon\Carbon;
use DateTime, Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ImportExportController extends Controller
{
    public $mensajes = [];

    public function showImportForm()
    {
      public  $titulos = [
            'id',
            'Date',
            'Libelle',
            'EURES',
            'FRANCS',
            'archivo traspaso',
            '# movimiento'
        ];

      public  $campos = [
            'id',
            'date',
            'libelle',
            'montantEUROS',
            'montantFRANCS',
            'NomArchTras',
            'IdArchMov'
        ];
        $totalImportados = Traspaso::count();
        $totalMovimientos = Traspaso::whereNotNull('IdArchMov')->count();

        $registrosDuplicados = DB::table('traspasosBanca')
            ->select(DB::raw("GROUP_CONCAT(CONCAT(Date, Libelle, MontantEUROS) SEPARATOR ', ') AS concat"))
            ->groupBy('Date', 'Libelle', 'MontantEUROS')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        $totalDuplicados = $registrosDuplicados->count();

        $data = Traspaso::all();
        // dd($data);

        return view('banca.import', ['data' => $data,  'titulos' => $titulos, 'campos' => $campos, 'totalImportados' => $totalImportados, 'totalMovimientos' => $totalMovimientos, 'totalDuplicados' => $totalDuplicados]);
    }

    public function import(Request $request)
    {
        // dd($request);

        // Validar el archivo enviado por el formulario
        $request->validate([
            'archivo' => 'required|array',
            'archivo.*' => 'file|mimes:csv,txt,tsv|max:2048',
        ], [
            'archivo.required' => 'El campo archivo es requerido.',
            'archivo.array' => 'El campo archivo debe ser un arreglo.',
            'archivo.*.file' => 'El archivo seleccionado no es válido.',
            'archivo.*.mimes' => 'El archivo debe tener una de las siguientes extensiones: csv, txt, tsv.',
            'archivo.*.max' => 'El tamaño máximo permitido para el archivo es de 2048 KB.',
        ]);


        $cnfTraspaso = [
            'separadorCampos' => $request->input('separador_campos'),
            'caracterString' => $request->input('caracter_string'),
            'finLinea' => $request->input('fin_linea'),
            'lineaEncabezados' => $request->input('linea_encabezados'),
        ];
        // Obtener los archivos enviados desde el formulario
        $archivos = $request->file('archivo');
        foreach ($archivos as $archivo) {

            // Obtener el nombre original del archivo
            $nombreOriginal = $archivo->getClientOriginalName();
            // $extension = $archivo->getClientOriginalExtension();

            // dd($archivo, $nombreOriginal, $extension);

            // Verificar si el archivo ya ha sido importado
            if ($this->checkFileImported($nombreOriginal)) {
                // dump(['Archivo ya traspasado: ' => $archivo]);
                $mensajes['error'] = "Archivo ya traspasado: $nombreOriginal";
                session()->put('error', $mensajes);
            } else {
                // Procede con la importación del archivo
                // try {
                // Determinar los campos y columnas correspondientes según la extensión del archivo
                $camposTabla = [
                    'Date',
                    'Libelle',
                    'MontantEUROS',
                    'MontantFRANCS',
                    'NomArchTras'
                    // 'Date' => 'date',
                    // 'Libelle' => 'text',
                    // 'MontantEUROS' => 'decimal,2',
                    // 'MontantFRANCS' => 'decimal,2',
                    // 'NomArchTras'
                ];

                // Columnas del archivo
                $camposArchivo = [
                    'Date',
                    'Libelle',
                    'MontantEUROS',
                    'MontantFRANCS',
                ];
                // dd(['camposTabla' => $camposTabla, 'camposArchivo' => $camposArchivo]);

                // Crear una instancia de TraspasoBancaImport con los parámetros necesarios
                $importador = new TraspasoBancaImport($nombreOriginal, $cnfTraspaso, $camposTabla); //, $camposArchivo
                // Importar los datos del archivo
                // dd(['archivo' => $archivo]);
                $importador->import($archivo);
                // dd(['importador' => $importador]);

                // Redireccionar o mostrar un mensaje de éxito
                $mensajes['success'] = "El archivo ($nombreOriginal) se ha importado.";
                session()->put('success', $mensajes);
                // } catch (\Exception $e) {
                //     // dd($archivo, $e->getMessage());
                //     $mensajes['error'] = 'Ha ocurrido un error al importar el archivo: ' . $e->getMessage();
                //     session()->put('error', $mensajes);
                // }
            }
        }
        // Session::flash('session', $mensajes);
        // dd("PARAR");
        return redirect()->back();
    }

    public function clientes()
    {

        // Obtener los registros de la tabla "client" en SQLite
        $clients = Client::all();


        $pais = new Pais();
        $pais->nombre = "Francia";
        // Asignar otros valores según corresponda
        $pais->save();

        // Recorrer los registros y transferir los datos a las tablas correspondientes en MySQL
        foreach ($clients as $client) {
            // Crear una entidad en la tabla "entidades" en MySQL
            $entidad = new Entidad();
            $entidad->nombres = $client->client;
            $entidad->eMail = $client->email;
            $entidad->tipo = 'Cliente';
            $entidad->is_active = 0;
            $primerosDosCaracteres = substr($client->client, 0, 2);

            if ((int)$primerosDosCaracteres > 0)
                $entidad->is_active = 1;
            // Asignar otros valores según corresponda
            try {
                //code...
                $entidad->save();
            } catch (\Throwable $th) {
                //throw $th;
                continue;
            }
            // Crear una dirección en la tabla "ciudades" en MySQL
            $ciudadNombre = ucwords(trim(preg_replace('/[0-9]/', '', trim($client->addr2))));
            if (strlen(trim($ciudadNombre)) < 5)
                $ciudadNombre = "Paris";
            $ciudadReg = Ciudad::where('nombre', $ciudadNombre)->first();
            if ($ciudadReg) {
                $ciudadId = $ciudadReg->id;
            } else {
                $ciudad = new Ciudad();
                $ciudad->pais_id = $pais->id;
                $ciudad->nombre = $ciudadNombre;
                // Asignar otros valores según corresponda
                $ciudad->save();
                $ciudadId = $ciudad->id;
            }

            // Crear una dirección en la tabla "direcciones" en MySQL
            if ($client->addr1) {
                $direccion = new Direccion();
                $direccion->entidad_id = $entidad->id;
                $direccion->direccion = $client->addr1;
                $direccion->ciudad_id = $ciudadId;
                $direccion->codigo_postal = trim(preg_replace('/[^0-9]/', '', $client->addr2));
                $direccion->region = $client->addr3;
                // Asignar otros valores según corresponda
                $direccion->save();
            }
            // Crear un teléfono en la tabla "telefonos" en MySQL
            if ($client->phone) {
                $telefono = new Telefono();
                $paso = trim(str_replace(' ', '', $client->phone));
                $telefono->entidad_id = $entidad->id;
                $telefono->tipo = '1';
                $telefono->numero = $paso;
                // Asignar otros valores según corresponda
                $telefono->save();
            }
            if ($client->fax) {
                $telefono = new Telefono();
                $telefono->tipo = '2';
                $telefono->entidad_id = $entidad->id;
                $paso = trim(str_replace(' ', '', $client->fax));
                $telefono->numero = $paso;
                // Asignar otros valores según corresponda
                $telefono->save();
            }
        }
        return redirect()->back()->with('success', 'tabla clientes traspasada');
    }
    public function checkFileImported($nombreArchivo)
    {
        try {
            $count = Traspaso::where('NomArchTras', $nombreArchivo)->count();
        } catch (\Throwable $th) {
            $count = 0;
        }

        return $count > 0;
    }

    public function eliminarRegistrosDuplicados()
    {
        // dd('eliminarRegistrosDuplicados');
        $registrosDuplicados = Traspaso::selectRaw('MIN(id) as min_id, CONCAT(Date, Libelle, MontantEUROS, MontantFRANCS) as concatFields')
            ->groupBy('Date', 'Libelle', 'MontantEUROS', 'MontantFRANCS')
            ->havingRaw('COUNT(*) > 1')
            ->get();

        foreach ($registrosDuplicados as $registro) {
            Traspaso::where('id', '<>', $registro->min_id)
                ->whereRaw('CONCAT(Date, Libelle, MontantEUROS, MontantFRANCS) = ?', [$registro->concatFields])
                ->delete();
        }

        return redirect()->back()->with('success', 'Registros duplicados eliminados correctamente');
    }

    public function TraspasoAMovimientos()
    {
        // Obtener los registros sin idArchMov de la tabla traspasos
        try {
            $registros = Traspaso::whereNull('idArchMov')->get();
            if ($registros) {
                foreach ($registros as $registro) {
                    // Crear un nuevo registro en la tabla movimiento_bancas
                    $movimiento = new Movimiento();

                    try {
                        $fechaFormateada = $this->castearDato($registro->Date, 'date1');
                        dd($fechaFormateada);
                        $montoFormateado = $this->castearDato($registro->MontantEUROS, 'float');
                        // dd(['fecha' => $fechaFormateada, 'monto' => $montoFormateado]);
                        $movimiento->dateMouvement = $fechaFormateada;
                        $movimiento->libelle = $registro->Libelle;
                        $movimiento->montant = $montoFormateado;
                        $movimiento->estado = 1; // Traspasada
                        //
                        $movimiento->save();

                        // Obtener el id del movimiento guardado
                        $idMovimiento = $movimiento->id;
                        // dd($idMovimiento);
                        // Actualizar el campo idArchMov en la tabla traspasos
                        $registro->idArchMov = $idMovimiento;
                        $registro->save();
                    } catch (\Throwable $e) {
                        // Manejar el error
                        // Puedes registrar el error, mostrar un mensaje o realizar alguna otra acción según tus necesidades
                        // Por ejemplo, puedes usar Log::error($e->getMessage()) para registrar el error en los logs
                        Log::error($e->getMessage());
                    }
                }
            } else {
                return redirect()->back()->with('success', 'No hay registros a mover');
            }
        } catch (\Throwable $e) {
            // Manejar el error
            // Puedes registrar el error, mostrar un mensaje o realizar alguna otra acción según tus necesidades
            // Por ejemplo, puedes usar Log::error($e->getMessage()) para registrar el error en los logs
            Log::error($e->getMessage());
        }
        return redirect()->back()->with('success', 'Registros movidos correctamente');
    }

    protected function castearDato($valor, $forzarTipo)
    {
        $valor2 = null;
        switch ($forzarTipo) {
            case 'alpha':
                try {
                    $valor2 = ctype_alpha($valor) ? $valor : null;
                } catch (\Throwable $e) {
                    $valor2 = null;
                    error_log("Error en castearDato: " . $e->getMessage());
                }
                break;
            case 'digit':
                try {
                    $valor2 = ctype_digit($valor) ? $valor : null;
                } catch (\Throwable $e) {
                    $valor2 = null;
                    error_log("Error en castearDato: " . $e->getMessage());
                }
                break;
            case 'float':
                try {
                    $valor2 = $this->convertirStringANumerico($valor);
                    $valor2 = is_numeric($valor2) ? floatval($valor2) : null;
                } catch (\Throwable $e) {
                    $valor2 = null;
                    error_log("Error en castearDato: " . $e->getMessage());
                }
                break;
            case 'bool':
                try {
                    $valor2 = filter_var($valor, FILTER_VALIDATE_BOOLEAN);
                } catch (\Throwable $e) {
                    $valor2 = null;
                    error_log("Error en castearDato: " . $e->getMessage());
                }
                break;
            case 'date1':
                try {
                    $valor2 = $this->parsearFecha($valor);
                } catch (\Throwable $e) {
                    $valor2 = null;
                    error_log("Error en castearDato: " . $e->getMessage());
                }
                break;
            case 'date2':
                try {
                    $valor2 = $this->parsearFecha2($valor);
                } catch (\Throwable $e) {
                    $valor2 = null;
                }
                break;
            case 'date3':
                try {
                    $valor2 = $this->parsearFecha2($valor);
                } catch (\Throwable $e) {
                    $valor2 = null;
                }
                break;
            case 'datetime':
                try {
                    $valor2 = $this->parsearFechaHora($valor);
                } catch (\Throwable $e) {
                    $valor2 = null;
                }
                break;
        }
        return $valor2;
    }

    function convertirStringANumerico($valor)
    {
        // Obtener el separador decimal actual
        $separadorDecimalActual = localeconv()['decimal_point'];

        // Reemplazar el separador decimal actual por un punto decimal
        $valorConPuntoDecimal = str_replace($separadorDecimalActual, '.', $valor);

        // Convertir el string en un valor numérico
        $valorNumerico = floatval($valorConPuntoDecimal);

        return $valorNumerico;
    }

    private function parsearFecha($valor)
    {
        if ($valor)
            try {
                $fecha = DateTime::createFromFormat('Y-m-d', $valor);
                return $fecha->format('Y-m-d');
            } catch (Exception $e) {
                // Error al parsear la fecha
                return null;
            }
    }


    protected function parsearFechaHora($valor)
    {
        try {
            return new DateTime($valor);
        } catch (Exception $e) {
            // Error al parsear la fecha
            return null;
        }
    }

    public function parsearFecha2($valor, $viene = "dd/mm/YY")
    {
        try {
            switch ($viene) {
                case "dd/mm/YY":
                    // Intentar formatear la fecha en el formato d/m/Y (dd/mm/YY)
                    $fechaCarbon = Carbon::createFromFormat('d/m/Y', $valor);
                    break;
                case "YY/mm/dd":
                    // Intentar formatear la fecha en el formato Y/m/d (YY/mm/dd)
                    $fechaCarbon = Carbon::createFromFormat('Y/m/d', $valor);
                    break;
                default:
                    throw new \Exception('Formato de fecha inválido');
                    break;
            }
        } catch (\Throwable $e) {
            dd($e);
            // Si ocurre un error, devolver un valor predeterminado o indicador de fecha inválida
            return null; // Valor predeterminado o indicador de fecha inválida
        }
        return $fechaCarbon; //->format('Ymd');
    }
    public function parsearFecha3($valor, $viene = "dd/mm/YY")
    {
        $fechaObjeto = DateTime::createFromFormat($viene, $valor);
        $fechaConvertida = $fechaObjeto->format('Ymd');
        return $fechaConvertida;
    }
}
