<nav class="bg-lightBg dark:bg-darkBg border-b border-gray-500 dark:border-gray-100">
  {{-- @dd($menus) --}}
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center h-16">
    {{--
    <!-- Logo -->
    <div class="flex-shrink-0">
      <a href="/" class="text-xl font-bold text-gray-800">MiLogo</a>
    </div> --}}

      <!-- Menú principal para pantallas grandes -->
      <div class="hidden md:flex space-x-4">
        @foreach ($menus as $menu)
        <div x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false" class="relative">
          <!-- Enlace principal -->
          <a href="{{ route($menu['route']) }}"
            class="block px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900">
            {{ __($menu['titulo']) }}
          </a>

          <!-- Submenú para pantallas grandes -->
          @if (isset($menu['submenu']))
          <div x-show="open" class="absolute z-50 mt-2 w-48 bg-white shadow-lg rounded-md">
            <div class="py-1">
              @foreach ($menu['submenu'] as $submenu)
              @include('partials.submenu', ['menu' => $submenu])
              @endforeach
            </div>
          </div>
          @endif
        </div>
        @endforeach
      </div>

      <!-- Botón de menú móvil -->
      <div class="md:hidden">
        <button @click="open = !open" x-data="{ open: false }"
          class="text-gray-500 hover:text-gray-700 focus:outline-none focus:text-gray-700">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-6 w-6">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
          </svg>
        </button>
      </div>
    </div>
  </div>

  <!-- Menú desplegable móvil -->
  <div x-data="{ open: false }" x-show="open" @click.away="open = false" class="md:hidden">
    <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
      @foreach ($menus as $menu)
      <div x-data="{ open: false }" class="relative">
        <!-- Enlace principal -->
        <a href="{{ route($menu['route']) }}"
          class="block px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 hover:text-gray-900 focus:outline-none focus:bg-gray-100 focus:text-gray-900">
          {{ __($menu['titulo']) }}
        </a>

        <!-- Submenú para móviles -->
        @if (isset($menu['submenu']))
        <button @click="open = !open"
          class="block px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 focus:outline-none">
          Submenús
        </button>
        <div x-show="open" class="mt-2 space-y-1 pl-4 border-l-2 border-gray-200">
          @foreach ($menu['submenu'] as $submenu)
          @include('partials.submenu', ['menu' => $submenu])
          @endforeach
        </div>
        @endif
      </div>
      @endforeach
    </div>
  </div>
</nav>