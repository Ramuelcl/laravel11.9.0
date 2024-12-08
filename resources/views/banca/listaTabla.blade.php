{{-- resources/views/banca/listaTabla --}}
<x-app-layout titulo="- Banca">
  <x-slot name="header">
    <h2>Gestión de Traspasos y Movimientos</h2>
  </x-slot>

  <x-forms.msgErrorsSession :errors="$errors" :success="session('success')" />
  <div>
    @livewire('tables.table-live', [
    'model' => $model,
    'fields' => $fields,
    'filters' => $filters,
    'perPage' => 10, // Opcional: elementos por página
    ])
  </div>
</x-app-layout>