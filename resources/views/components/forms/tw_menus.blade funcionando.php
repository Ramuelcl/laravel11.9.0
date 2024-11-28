@props(['tabla' => '10000'])
@php
use App\Models\backend\Tabla;
$m = new Tabla;
$menus = $m->getMenu($tabla);
// dd($menus);
@endphp
<div>
  @if (empty($menus))
  <p>No hay menús disponibles.</p>
  @else
  @foreach ($menus as $title => $menu)
  <!-- Clase activa -->
  <x-nav-link :href="route($menu['route'])" :active="request()->routeIs($menu['route'])" class="flex items-center">
    @isset($menu['icon'])
    <x-forms.tw_icons name="{{ $menu['icon'] }}" :error="false" />
    @endisset
    {{ __($menu['titulo']) }}
  </x-nav-link>

  <!-- Submenús -->
  @if (isset($menu['submenu']))
  <div class="ml-4 pl-4 border-l border-gray-700">
    @foreach ($menu['submenu'] as $subTitle => $subMenu)
    <x-nav-link :href="route($subMenu['route'])" :active="request()->routeIs($subMenu['route'])"
      class="flex items-center">
      @isset($subMenu['icon'])
      <x-forms.tw_icons name="{{ $subMenu['icon'] }}" :error="false" />
      @endisset
      {{ __($subMenu['titulo']) }}
    </x-nav-link>
    @endforeach
  </div>
  @endif
  @endforeach
  @endif
</div>