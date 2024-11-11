<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', config('guzanet.idioma', 'fr-FR')) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('guzanet.appEmpresa', 'Guzanet.') }}</title>

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.bunny.net">
  <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
  {{--fontawesome --}}
  <link rel="stylesheet" href="{{ asset('resources/css/all.min.css') }}">
  <!-- Scripts -->
  @vite(['resources/css/app.css','resources/css/styles.css','resources/css/all.min.css', 'resources/js/app.js',
  'resources/js/dark.js'])
  @livewireStyles
  <style>
    .sidebar-light-pink .nav-sidebar>.nav-item>.nav-link.active {
      background-color: #e83e8c;
      color: #fff;
    }
  </style>
</head>