@php
  use Illuminate\Support\Facades\{App, Artisan, File, Route};

  Artisan::call('storage:link');

  // Crear directorios si no existen
  $directories = ['app', 'avatars', 'flags'];
  foreach ($directories as $directory) {
      $target = '/storage/app/public/images/' . $directory;
      $shortcut = public_path('storage/images/' . $directory);

      // Crear el directorio si no existe
      if (!File::isDirectory($shortcut)) {
          File::makeDirectory($shortcut, 0777, true, true);
      }

      // Crear el enlace simbólico si no existe
      if (!File::exists($shortcut)) {
          symlink($target, $shortcut);
      }
  }
  $source = public_path('images/app/logo/guzanet.png');
  $target = public_path('storage/images/app/guzanet.png');

  // Cargar y crear el archivo SVG con el contenido
  // $target = public_path('images/guzanet.svg');
  // $svgContent = file_get_contents($target);
  // file_put_contents($source, $svgContent);

  // Copiar el archivo a guzanet.svg
  copy($source, $target);

  return "Enlace simbólico y directorios creados correctamente.
        <br><br>
        <a href='/'>Volver a la página principal</a>
        <br>
        <a href='/readstorage'>mostrarlos</a>";
@endphp
<x-app-layout>
  <div class="flex content-between justify-between">
    <h2 class="font-extrabold"> {{ __('Storage...') }}</h2>

  </div>
  <div>
    <button onclick="redirigir" type="button">ir a Dashboard</button>
  </div>
  <div>
    <div class="border-b border-gray-200 p-6">
      {{ __('creando link a Storage ') }}
    </div>
  </div>
</x-app-layout>
