<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

  <!-- Scripts -->
  @livewireStyles
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
  <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
    @include('layouts.navigation')

    <!-- Page Heading -->
    @isset($header)
    <header class="bg-white dark:bg-gray-800 shadow">
      <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
        {{ $header }}
      </div>
    </header>
    @endisset

    <!-- Page Content -->
    <main class="inline-flex">
      <div x-data="{ show: false }">
        <x-forms.tw_button color="green" class="m-4" @click="show = !show">Toggle</x-forms.tw_button>
        <span x-show="show">Hello, World!</span>
      </div>
      {{ $slot ?? null}}
    </main>
    <!-- Page Footer -->
    {{-- @isset($footer)
    @include('layouts.includes.footer2')
    @endisset --}}
  </div>
  @livewireScriptConfig
</body>

</html>