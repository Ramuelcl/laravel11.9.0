@php
$menus = [
'Blog' => ['id' => 1, 'route' => 'blog', 'icon' => '', 'active' => request()->routeIs('blog')],
'Portfolio' => ['id' => 2, 'route' => 'portfolio', 'icon' => '', 'active' => request()->routeIs('portfolio'), 'disabled'
=> true],
'Profile' => ['id' => 3, 'route' => 'profile', 'icon' => '', 'submenu' => true, 'active' =>
request()->routeIs('profile*')],
];

$submenus = [
'Edit' => ['id' => 3, 'route' => 'profile.edit', 'icon' => '', 'active' => request()->routeIs('profile.edit')],
'Update' => ['id' => 3, 'route' => 'profile.update', 'icon' => '', 'method' => 'PATCH', 'active' =>
request()->routeIs('profile.update')],
'More Options' => [
'id' => 3, 'icon' => '', 'submenu' => [
'Change Password' => ['route' => 'profile.password', 'icon' => '', 'active' => request()->routeIs('profile.password'),
'disabled' => true],
'Privacy Settings' => ['route' => 'profile.privacy', 'icon' => '', 'active' => request()->routeIs('profile.privacy')]
]
],
];
@endphp

<!-- Menú principal -->
@foreach ($menus as $title => $menu)
<div x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" class="relative inline-block">
  <div
    class="flex items-center {{ !isset($menu['disabled']) || !$menu['disabled'] ? 'group' : 'opacity-50 cursor-not-allowed' }}">
    @if (!isset($menu['disabled']) || !$menu['disabled'])
    <x-nav-link :href="route($menu['route'])" :active="$menu['active']" class="flex items-center">
      @isset($menu['icon'])
      <x-forms.tw_icons name="{{ $menu['icon'] }}" :error="false" />
      @endisset
      {{ __($title) }}
    </x-nav-link>
    @else
    <div class="px-2 py-1 rounded-lg flex items-center text-xs">
      @isset($menu['icon'])
      <x-forms.tw_icons name="{{ $menu['icon'] }}" :error="false" />
      @endisset
      {{ __($title) }}
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
  @if(isset($menu['submenu']) && $menu['submenu'] === true)
  <div x-show="open" x-transition:enter="transition ease-out duration-100"
    x-transition:leave="transition ease-in duration-75"
    class="bg-lightBg dark:bg-darkBg absolute right-0 mt-2 w-full origin-top-right rounded-md shadow-lg px-2 py-2 md:w-48 z-50">

    @foreach ($submenus as $subTitle => $submenu)
    @if ($submenu['id'] === $menu['id'])
    <!-- Submenú anidado -->
    @if (isset($submenu['submenu']))
    <div x-data="{ subOpen: false }" @mouseenter="subOpen = true" @mouseleave="subOpen = false" class="relative">
      <button type="button" class="w-full text-left px-4 py-2 text-sm rounded-md flex items-center">
        @isset($submenu['icon'])
        <x-forms.tw_icons name="{{ $submenu['icon'] }}" :error="false" />
        @endisset
        {{ __($subTitle) }}
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
        @foreach ($submenu['submenu'] as $subSubTitle => $subSubmenu)
        <x-nav-link :href="route($subSubmenu['route'])" :active="$subSubmenu['active']"
          class="w-full text-left px-4 py-2 text-sm rounded-md {{ isset($subSubmenu['disabled']) && $subSubmenu['disabled'] ? 'opacity-50 cursor-not-allowed' : '' }}">
          @isset($subSubmenu['icon'])
          <x-forms.tw_icons name="{{ $subSubmenu['icon'] }}" :error="false" />
          @endisset
          {{ __($subSubTitle) }}
        </x-nav-link>
        @endforeach
      </div>
    </div>
    @elseif (isset($submenu['method']) && in_array($submenu['method'], ['PATCH', 'DELETE']))
    <form method="POST" action="{{ route($submenu['route']) }}" class="nav-link">
      @csrf
      @method($submenu['method'])
      <button type="submit" class="w-full text-left px-4 py-2 text-sm rounded-md">
        @isset($submenu['icon'])
        <x-forms.tw_icons name="{{ $submenu['icon'] }}" :error="false" />
        @endisset
        {{ __($subTitle) }}
      </button>
    </form>
    @else
    <x-nav-link :href="route($submenu['route'])" :active="$submenu['active']"
      class="w-full text-left px-4 py-2 text-sm rounded-md">
      @isset($submenu['icon'])
      <x-forms.tw_icons name="{{ $submenu['icon'] }}" :error="false" />
      @endisset
      {{ __($subTitle) }}
    </x-nav-link>
    @endif
    @endif
    @endforeach
  </div>
  @endif
</div>
@endforeach