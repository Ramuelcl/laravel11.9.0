<?php
// Database\Seeders\ImportDataSeeder.php

namespace Database\Seeders;

use App\Models\Backend\Ciudad;
use App\Models\Backend\CodigoPostal;
use App\Models\Backend\Direccion;
use App\Models\Backend\Email;
use App\Models\Backend\Entidad;
use App\Models\Backend\Pais;
use App\Models\Backend\Telefono;
use Illuminate\Database\Seeder;

class ImportDataSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    // Eliminar todas las entidades con IDs mayores o iguales a 6
    Entidad::where('entidad', '>=', 6)->delete();

    // Crear un país y una ciudad de ejemplo
    $pais = Pais::factory()->create();
    $ciudad = Ciudad::factory()->create(['pais_id' => $pais->id]);

    // Crear un código postal para la ciudad
    $codigoPostal = CodigoPostal::factory()->create(['ciudad_id' => $ciudad->id]);

    // Crear entidades
    Entidad::factory(10)->create()->each(function ($entidad) use ($codigoPostal) {
      // Crear direcciones para cada entidad
      Direccion::factory(2)->create([
        'entidad_id' => $entidad->id,
        'cp_id' => $codigoPostal->id,
      ]);

      // Crear correos electrónicos para cada entidad
      Email::factory(2)->create([
        'entidad_id' => $entidad->id,
      ]);

      // Crear teléfonos para cada entidad
      Telefono::factory(2)->create([
        'entidad_id' => $entidad->id,
      ]);
    });
  }
}
