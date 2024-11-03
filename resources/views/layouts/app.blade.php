<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('guzanet.appEmpresa', 'Guzanet.') }}</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

  <!-- Scripts -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @livewireStyles
</head>

<body class="font-sans antialiased bg-lightBg text-lightText dark:bg-darkBg dark:text-darkText">
  <div class="min-h-screen">
    <!-- Page Heading -->
    <header
      class="bg-lightBg/70 text-lightText/70 dark:bg-darkBg/70 dark:text-darkText/70 shadow font-semibold text-xl leading-tight">
      @include('layouts.navigation')
      @isset($header)
      <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        {{ $header }}
      </div>
      @endisset
    </header>

    <!-- Page Content -->
    <main>
      {{-- Contenido para Livewire o Blade --}}
      @isset($slot)
      {{ $slot }}
      <!-- Para componentes Livewire -->
      @else
      @yield('content')
      <!-- Para vistas Blade normales -->
      @endisset
    </main>

    @isset($footer)
    <footer class="bg-lightBg/70 text-lightText/70 dark:bg-darkBg/70 dark:text-darkText/70 font-thin text-end text-xs">
      <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        {{ $footer }}
      </div>
    </footer>
    @endisset

  </div>
  @livewireScripts

</body>

</html>