<?php

namespace Database\Seeders;

use App\Models\backend\categoria;
use App\Models\post\post;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   *
   * @return void
   */
  public function run()
  {
    /**
     * usando Storage
     * en tiempo  de ejecución
     *

     *    use Illuminate\Support\Facades\Storage;

     *   $disk = Storage::build([
     *       'driver' => 'local',
     *       'root' => '/path/to/root',
     *   ]);

     *   $disk->put('image.jpg', $content);
     **/

    /**
     * usando Storage
     **/
    // $folders=['images','icons', 'avatars', 'cursos','posts'];
    // foreach ($folders as $folder) {
    //     if (Storage::exists('\\public\\'.$folder)) {
    //         Storage::deleteDirectory('\\public\\'.$folder);
    //     }
    //     Storage::makeDirectory('\\public\\'.$folder);
    // }
    // Storage::disk('local')->put('example.txt', 'Contents 3221Contenido');// storage/app/
    // echo asset('local').'/file.txt ';

    // Storage::copy($folder, public_path().'banca.yaml');
    // dd(public_path(), storage_path(), public_path("storage"), storage_path('storage'), env('APP_URL').'/public/storage', $folders, $folder);

    $this->call([
      TablaSeeder::class,
      MarcadorSeeder::class,
      //
      RoleSeeder::class,
      UserSeeder::class,
      //
      // EntidadSeeder::class,
      ImportDataSeeder::class,
      //
      // TelefonoSeeder::class,
      // DireccionSeeder::class,
      // CategoriaSeeder::class,
      // TaskSeeder::class,
      //
      // BancaSeeder::class,
      // CompteSeeder::class,
      // MouvementSeeder::class,
      // CursoSeeder::class,
      // ClientSeeder::class,
      // ProjectSeeder::class,
      // InvoiceSeeder::class,
    ]);

    // Seed categories
    categoria::factory()->count(5)->create();

    // Seed posts
    // post::factory()->count(10)->create();
  }
}
