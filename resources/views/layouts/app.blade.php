<!DOCTYPE html>
<html lang="fr-FR">
{{-- <html lang="{{ str_replace('_', '-', config('guzanet.idioma', 'fr-FR')) }}"> --}}

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('guzanet.appEmpresa', 'Guzanet.') }}</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

  <!-- Scripts -->
  @vite(['resources/css/app.css','resources/css/styles.css', 'resources/js/app.js', 'resources/js/dark.js'])
  @livewireStyles
</head>

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
      <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        {{ $header }}
      </div>
      @else
      @yield('header')
      @endisset
    </header>

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

    <!-- Footer -->
    <footer
      class="bg-lightBg/70 text-lightText/70 dark:bg-darkBg/70 dark:text-darkText/70 font-thin text-end text-xs py-4">
      <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        @isset($footer)
        {{ $footer }}
        @else
        @yield('footer')
        @endisset
      </div>
    </footer>
  </div>

  @livewireScripts
</body>

</html>