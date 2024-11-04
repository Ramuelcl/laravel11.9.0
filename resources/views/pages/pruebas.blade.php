{{-- resources/views/pruebas.blade.php --}}
@extends('layouts.app')

@section('header')
<div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
  {{ __('To Do') }}
</div>
@endsection
@section('content')
<h1 class="text-xl font-semibold mb-4">Página de Pruebas para Ventana Modal</h1>

{{-- Botón para abrir el modal en modo modal --}}
<button onclick="abrirModal(true)" class="bg-blue-500 text-white px-4 py-2 rounded-md">
  Abrir en modo Modal
</button>

{{-- Botón para abrir el modal en modo no modal --}}
<button onclick="abrirModal(false)" class="bg-green-500 text-white px-4 py-2 rounded-md">
  Abrir en modo No Modal
</button>

{{-- Incluir el componente tw_window --}}
<x-forms.tw_window title="Mi Ventana Modal" width="w-1/2" :modal="true">
  {{-- Ejemplo de campo de texto --}}
  <x-forms.tw_input id="username" name="username" label="Nombre de usuario" />

  {{-- Ejemplo de campo de contraseña con mostrar/ocultar --}}
  <x-forms.tw_input id="password" name="password" label="Contraseña" type="password" />

  {{-- Ejemplo de checkbox --}}
  <x-forms.tw_input id="agree" name="agree" label="Acepto los términos" type="checkbox" />

  {{-- Ejemplo de select --}}
  <x-forms.tw_input id="gender" name="gender" label="Género" type="select"
    :options="['male' => 'Masculino', 'female' => 'Femenino']" />
</x-forms.tw_window>
@endsection