<x-app-layout titulo="- Banca">
  <x-slot name="header">
    <h2>Gestión de Traspasos y Movimientos</h2>
  </x-slot>

  <x-forms.msgErrorsSession :errors="$errors" :success="session('success')" />

  <!-- Layout con dos columnas -->
  <div class="grid grid-cols-1 md:grid-cols-2 gap-8 p-4">
    <!-- Columna 1: Traspaso -->
    <div class="bg-white p-4 shadow rounded">
      <h3 class="font-bold text-lg mb-4">Traspasar Archivos</h3>

      <form method="POST" action="{{ route('banca.import') }}" enctype="multipart/form-data">
        @csrf
        <x-forms.tw_input type="file" name="archivo[]" id="archivo" multiple required />
        <x-forms.tw_input type="text" name="marcador" id="marcador" required value="Date\tLibell"
          label="Marcador de inicio" />

        <button type="submit" id="btn-importar" class="bg-green-500 text-white py-2 px-4 rounded w-full mt-4"
          wire:loading.attr="disabled">
          <span wire:loading.remove>Importar Archivos</span>
          <span wire:loading>Procesando...</span>
        </button>
      </form>
    </div>

    <!-- Columna 2: Pasar a Movimientos -->
    <div class="bg-white p-4 shadow rounded">
      <h3 class="font-bold text-lg mb-4">Pasar a Movimientos</h3>

      <div>
        <p class="mb-4">
          <span class="font-bold">Registros disponibles:</span> {{ $totalPendientes }}
        </p>
      </div>

      <form action="{{ route('banca.crearMovimientos') }}" class="w-full">
        <button type="submit" id="btn-pasar-movimientos" class="bg-yellow-500 text-white py-2 px-4 rounded w-full"
          wire:loading.attr="disabled">
          <span wire:loading.remove>Pasar a Movimientos</span>
          <span wire:loading>Procesando...</span>
        </button>
      </form>

      <!-- Contador dinámico -->
      <div class="mt-6">
        <p class="font-bold text-center">Procesados: <span wire:poll>{{ $totalPendientes }}</span></p>
      </div>
    </div>
  </div>
  <!-- Aquí muestra la grilla de datos -->
  @if ($data)
  {{-- @dd($data) --}}
  @livewire('tables.live-tabla', [
  'data' => $data, // Pasamos todos los datos (sin paginación)
  'encabezado' => 'Datos Transferidos',
  'titulos' => $titulos,
  'campos' => $campos
  ])
  @endif
</x-app-layout>