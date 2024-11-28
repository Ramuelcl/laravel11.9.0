@props(['tabla' => '10020'])
@php
use App\Models\backend\Tabla;
$m = new Tabla;
$menus = $m->getMenu($tabla);
// dd($menus);
@endphp
<!-- Menú principal -->
@foreach ($menus as $id => $menu)
<div x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" class="relative inline-block z-50">
  <div
    class="flex items-center {{ !isset($menu['disabled']) || !$menu['disabled'] ? 'group' : 'opacity-50 cursor-not-allowed' }}">
    {{-- @dd($menu); --}}
    @if (!isset($menu['disabled']) || !$menu['disabled'])
    @isset($menu['route'])
    <x-nav-link :href="route($menu['route'])" :active="request()->routeIs($menu['route'])" class="flex items-center">
      @isset($menu['icon'])
      <x-forms.tw_icons name="{{ $menu['icon'] }}" :error="false" />
      @endisset
      {{ __($menu['titulo']) }}
    </x-nav-link>
    @endisset
    @else
    <div class="px-2 py-1 rounded-lg flex items-center text-xs">
      @isset($menu['icon'])
      <x-forms.tw_icons name="{{ $menu['icon'] }}" :error="false" />
      @endisset
      {{ __($menu['titulo']) }}
    </div>
    @endif

    <!-- Icono de flecha (solo si 'submenu' es true) -->
    @if(isset($menu['submenu']) && $menu['submenu'] === true)
    <svg fill="currentColor" viewBox="0 0 20 20" :class="{ 'rotate-180': open, 'rotate-0': !open }"
      class="ml-1 h-4 w-4 transform transition-transform duration-200 group-hover:rotate-180">
      <path fill-rule="evenodd"
        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
        clip-rule="evenodd"></path>
    </svg>
    @endif
  </div>

  <!-- Contenedor del submenú (solo si 'submenu' es true) -->
  @if (isset($menu['submenu']) && is_array($menu['submenu']) && count($menu['submenu']) > 0)
  <div x-show="open" x-transition:enter="transition ease-out duration-100"
    x-transition:leave="transition ease-in duration-75"
    class="bg-lightBg dark:bg-darkBg absolute right-0 mt-2 w-full origin-top-right rounded-md shadow-lg px-2 py-2 md:w-48 z-50">

    @foreach ($menu['submenu'] as $item)
    {{-- @dd($menu, $item) --}}
    <!-- Submenú anidado -->
    @if (isset($item['submenu']))
    <div x-data="{ subOpen: false }" @mouseenter="subOpen = true" @mouseleave="subOpen = false" class="relative">
      <button type="button" class="w-full text-left px-4 py-2 text-sm rounded-md flex items-center">
        @isset($item['icon'])
        <x-forms.tw_icons name="{{ $item['icon'] }}" :error="false" />
        @endisset
        {{ __($item['titulo']) }}
        <svg fill="currentColor" viewBox="0 0 20 20" :class="{ 'rotate-180': subOpen, 'rotate-0': !subOpen }"
          class="ml-1 h-4 w-4 transform transition-transform duration-200">
          <path fill-rule="evenodd"
            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
            clip-rule="evenodd"></path>
        </svg>
      </button>

      <!-- Submenú anidado desplegable -->
      <div x-show="subOpen" x-transition:enter="transition ease-out duration-100"
        x-transition:leave="transition ease-in duration-75"
        class="bg-lightBg dark:bg-darkBg absolute left-full top-0 mt-0 w-full origin-top-right rounded-md shadow-lg px-2 py-2 md:w-48 z-50">
        @foreach ($item['submenu'] as $subSubId => $subSubmenu)
        @isset($item['route']))
        <x-nav-link :href="route($subSubmenu['route'])" :active="request()->routeIs($subSubmenu['route'])"
          class="w-full text-left px-4 py-2 text-sm rounded-md {{ isset($subSubmenu['disabled']) && $subSubmenu['disabled'] ? 'opacity-50 cursor-not-allowed' : '' }}">
          @isset($subSubmenu['icon'])
          <x-forms.tw_icons name="{{ $subSubmenu['icon'] }}" :error="false" />
          @endisset
          {{ __($subSubmenu['titulo']) }}
        </x-nav-link>
        @endisset
        @endforeach
      </div>
    </div>
    @elseif (isset($item['method']) && in_array($item['method'], ['PATCH', 'DELETE']))
    <form method="POST" action="{{ route($item['route']) }}" class="nav-link">
      @csrf
      @method($item['method'])
      <button type="submit" class="w-full text-left px-4 py-2 text-sm rounded-md">
        @isset($item['icon'])
        <x-forms.tw_icons name="{{ $item['icon'] }}" :error="false" />
        @endisset
        {{ __($item['titulo']) }}
      </button>
    </form>
    @else
    <x-nav-link :href="route($item['route'])" :active="request()->routeIs($item['route'])"
      class="w-full text-left px-4 py-2 text-sm rounded-md">
      @isset($item['icon'])
      <x-forms.tw_icons name="{{ $item['icon'] }}" :error="false" />
      @endisset
      {{ __($item['titulo']) }}
    </x-nav-link>
    @endif
    @endforeach
  </div>
  @endif
</div>
@endforeach