<?php
// Database\Seeders\ImportDataSeeder.php

namespace Database\Seeders;

use App\Models\backend\Ciudad;
use App\Models\backend\CodigoPostal;
use App\Models\Backend\Direccion;
use App\Models\Backend\Email;
use App\Models\Backend\Entidad;
use App\Models\backend\Pais;
use App\Models\Backend\Telefono;
use function PHPUnit\Framework\isNull;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Str;

class ImportDataSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {

    $records = DB::connection('origen2') // usa el nombre de tu conexión 
      ->table('entidades')
      ->orderBy('nombres')
      ->get();
    // Eliminar todas las entidades con IDs iguales a 2
    Entidad::where('tipoEntidad', '=', 2)->delete();
    foreach ($records as $record) {

      // Initialize $nombre to an empty string in case no space is found
      $nombre = "";
      $id = null;
      // Find the first space in the string
      $spacePos = strpos(trim($record->nombres), ' ');
      if ($spacePos !== false) {
        // If a space is found, extract ID and name
        $id = (int)substr($record->nombres, 0, $spacePos);
        $nombre = trim(substr($record->nombres, $spacePos + 1));
      } else {
        // If no space is found, assume the entire string is the ID
        $nombre = $record->nombres;
      }
      // Crea la entidad
      $entidad = Entidad::factory()->create([
        'id' => $id ?? null,
        'tipoEntidad' => 2,
        'nombres' => $nombre,
        'apellidos' => $record->apellidos,
        'is_active' => $record->is_active,
        'titulo' => null,
        'razonSocial' => null,
        'website' => null,
        'sexo' => null,
        'aniversario' => null,
        'created_at' => $this->parseDate($record->created_at),
      ]);
      $pais_id = $this->fncCreaPais('France');
      
      if(!is_null($record->direccion)) {
        $campo = $record->direccion;
        $parts = explode(' ', $campo);
        // dump($parts);
        if (sizeof($parts) > 1) {
          // Get the last part, which is likely the number
          $numero = trim(array_shift($parts));
          $calle = trim(implode(' ', $parts)); // Combine all parts except the last one
        } else {
          $numero = null;
          $calle = null;
        }
        $ciudad_id = $this->fncCreaCiudad($record->ciudad, $pais_id);
        $cp_id = $this->fncCreaCP($record->cp, $ciudad_id);
        Direccion::factory()->create([
          'entidad_id' => $entidad->id,
          'numero' => $numero,
          'calle' => $calle,
          'tipo' => 1,
          'cp_id' => $cp_id ?? 0,
        ]);
      }
      if(!is_null($record->eMail)) {
        Email::factory()->create([
          'entidad_id' => $entidad->id,
          'mail' => $record->eMail,
          'tipo' => 1,
        ]);
      }
      if(!is_null($record->telefono1)) {
        Telefono::factory()->create([
          'entidad_id' => $entidad->id,
          'numero' => $record->telefono1,
          'tipo' => 1,
        ]);
      }
      if(!is_null($record->telefono2)) {
        Telefono::factory()->create([
          'entidad_id' => $entidad->id,
          'numero' => $record->telefono2,
          'tipo' => 2,
        ]);
      }
    }
    // Obtén todos los registros de la tabla import
    $records = DB::connection('origen1') // usa el nombre de tu conexión de origen
      ->table('import')
      ->get();
    // Eliminar todas las entidades con IDs iguales a 6
    Entidad::where('tipoEntidad', '=', 6)->delete();

    foreach ($records as $record) {
      // dump($record);
      // Crea la entidad
      $entidad = Entidad::factory()->create([
        'tipoEntidad' => 6,
        'nombres' => $record->{"Given Name"},
        'apellidos' => $record->{"Family Name"},
        'razonSocial' => $record->{"Organization 1 - Name"},
        'website' => $record->{"Website 1 - Value"},
        'sexo' => $this->mapGender($record->{"Gender"}),
        'aniversario' => $this->parseDate($record->{"Birthday"}),
      ]);
      for ($i = 1; $i <= 2; $i++) {
        $campo = $record->{"Address $i - Street"};
        if (!empty($campo)) {
          $pais_id = $this->fncCreaPais($record->{"Address $i - Country"});
          $ciudad_id = $this->fncCreaCiudad($record->{"Address $i - City"}, $pais_id);
          $cp_id = $this->fncCreaCP($record->{"Address $i - Postal Code"}, $ciudad_id);

          $parts = explode(' ', $campo);
          // dump($parts);
          if (sizeof($parts) > 1) {
            // Get the last part, which is likely the number
            $numero = trim(array_shift($parts));
            $calle = trim(implode(' ', $parts)); // Combine all parts except the last one
          } else {
            $numero = null;
            $calle = null;
          }
          // dd($numero, $calle);
          // Crea direcciones
          if(!is_null($calle))
            Direccion::factory()->create([
              'entidad_id' => $entidad->id,
              'calle' => $calle,
              'numero' => $numero,
              'tipo' => $this->mapAddressType($record->{"Address $i - Type"}),
              'cp_id' => $cp_id ?? 0,
            ]);
        }
      }

      // Crea correos electrónicos
      for ($i = 1; $i <= 2; $i++) {
        $campo = $record->{"E-mail $i - Value"};
        if (!empty($campo)) {
          Email::factory()->create([
            'entidad_id' => $entidad->id,
            'mail' => $campo,
            'tipo' => $this->mapEmailType($record->{"E-mail $i - Type"}),
          ]);
        }
      }


      // Crea teléfonos
      for ($i = 1; $i <= 2; $i++) {
        $campo = $record->{"Phone $i - Value"};
        if (!empty($campo)) {
          Telefono::factory()->create([
            'entidad_id' => $entidad->id,
            'numero' => $campo,
            'tipo' => $this->mapEmailType($record->{"Phone $i - Type"}),
          ]);
        }
      }
    }
  }

  /**
   * Map gender values to integers.
   */
  protected function mapGender($gender)
  {
    if ($gender == 1)
      return 1;
    else
      return 2;
  }

  /**
   * Parse date from string.
   */
  protected function parseDate($date)
  {
    return !empty($date) ? date('Y-m-d', strtotime($date)) : null;
  }

  /**
   * Map address type to an integer.
   */
  protected function mapAddressType($type)
  {
    $typeMap = [
      'Home' => 1,
      'Work' => 2,
      'Other' => 99,
    ];

    return $typeMap[$type] ?? 1;
  }

  /**
   * Map email type to an integer.
   */
  protected function mapEmailType($type)
  {
    $type = trim($type) ? $type : "Home";
    $type = preg_replace('/[^a-zA-Z]/', '', $type);
    // dump($type);
    $typeMap = [
      'Home' => 1,
      'Particular' => 1,
      'Work' => 2,
      'Other' => 99,
    ];
    return $typeMap[$type] ?? 1;
  }

  /**
   * Map phone type to an integer.
   */
  protected function mapPhoneType($type)
  {
    $typeMap = [
      'Mobile' => 1,
      'Home' => 2,
      'Work' => 3,
      'Other' => 99,
    ];

    return $typeMap[$type] ?? 1;
  }

  protected function fncCreaCP($cp, $ciudad_id = "0")
  {
    $cp = trim($cp) ? $cp : "00000";

    // Busca si el código postal ya existe
    $cp_existe = CodigoPostal::where('cp', $cp)->first();

    // Si el código postal existe, devuelve su id
    if ($cp_existe) {
      return $cp_existe->id;
    }

    // Si no existe, crea un nuevo registro de código postal
    $nuevo_cp = new CodigoPostal();
    $nuevo_cp->cp = $cp;
    $nuevo_cp->ciudad_id = $ciudad_id;
    $nuevo_cp->save();

    // Devuelve el id del nuevo código postal creado
    return $nuevo_cp->id;
  }

  protected function fncCreaCiudad($nombreCiudad=null, $pais_id)
  {
    if(is_null($nombreCiudad)) return null;
    // Busca si la ciudad ya existe
    $ciudad_existe = Ciudad::where('nombre', $nombreCiudad)->first();

    // Si la ciudad existe, devuelve su id
    if ($ciudad_existe) {
      return $ciudad_existe->id;
    }

    // Si no existe, crea un nuevo registro de ciudad
    $nueva_ciudad = new Ciudad();
    $nueva_ciudad->nombre = $nombreCiudad;
    $nueva_ciudad->pais_id = $pais_id;
    $nueva_ciudad->save();

    // Devuelve el id de la nueva ciudad creada
    return $nueva_ciudad->id;
  }

  protected function fncCreaPais($nombrePais){
    $nombrePais = Str::upper($nombrePais);
    $nombrePais = substr($nombrePais, 0, 4) == 'CHIL' ? 'CHILE' : $nombrePais;
    $nombrePais = trim($nombrePais) ? $nombrePais : "FRANCE";

    // Busca si pais ya existe
    $pais_existe = Pais::where('nombre', $nombrePais)->first();

    // Si pais existe, devuelve su id
    if ($pais_existe) {
      return $pais_existe->id;
    }

    // Si no existe, crea un nuevo registro de pais
    $nuevo_pais = new Pais();
    $nuevo_pais->nombre = $nombrePais;
    $nuevo_pais->save();

    // Devuelve el id del nuevo pais
    return $nuevo_pais->id;
  }
}
