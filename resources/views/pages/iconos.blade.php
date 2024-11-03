<x-app-layout titulo="- Iconos">
  {{-- resources/views/components/forms/principal/iconos.blade.php --}}
  @php
  $directory = public_path('app\icons\outline');
  // Reemplaza esto con la ruta al directorio que contiene los íconos SVG
  // dd($directory);

  $icons = scandir($directory);
  $svgIcons = [];

  foreach ($icons as $icon) {
  // dump(pathinfo($icon, PATHINFO_EXTENSION));
  if (pathinfo($icon, PATHINFO_EXTENSION) === 'php') {
  $icon = str_replace('.blade.php', '', $icon);
  // dump($icon);
  $svgIcons[] = $icon;
  }
  }
  @endphp

  <div class="flex flex-wrap">
    @foreach ($svgIcons as $svgIcon)
    <div class="p-4 m-2 rounded-lg border-2 border-blue-400 text-center">
      <x-forms.tw_icons class="" name="{{ $svgIcon }}" />{{ $svgIcon }}
    </div>
    @endforeach
  </div>
</x-app-layout>