@include('layouts.includes.head')

<body class="font-sans antialiased bg-lightBg text-lightText dark:bg-darkBg dark:text-darkText">
  <div class="min-h-screen flex flex-col justify-between">
    <!-- Page Heading -->
    <header
      class="bg-lightBg/70 text-lightText/70 dark:bg-darkBg/70 dark:text-darkText/70 shadow font-semibold text-xl leading-tight">
      {{-- Navegación --}}
      {{-- @include('layouts.navigation') --}}
      <x-navigation.primary />
      <!-- Encabezado de la página -->
      @isset($header)
      <div class="max-w-7xl mx-auto py-2 px-4 sm:px-6 lg:px-8">
        {{ $header }}
      </div>
      @else
      @yield('header')
      @endisset
    </header>
    <!-- Sidebar Menu -->

    <!-- Page Content -->
    <main class="flex-grow">
      <div class="p-4 max-w-7xl mx-auto sm:px-6 lg:px-8">
        @isset($slot)
        {{ $slot }}
        @else
        @yield('content')
        @endisset
      </div>
    </main>
    <footer
      class="bg-lightBg/70 text-lightText/70 dark:bg-darkBg/70 dark:text-darkText/70 font-thin text-end text-xs pt-2 border-t px-4">
      @include(' layouts.includes.footer0')
    </footer>
  </div>

  @livewireScripts
</body>

</html>