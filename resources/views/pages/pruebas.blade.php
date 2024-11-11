{{-- resources/views/livewire/pruebas.blade.php --}}
<div class="container mx-auto p-4">
  <h1 class="text-xl font-semibold mb-4">Página de Pruebas para Ventanas Modal y No Modal</h1>

  {{-- Botón para mostrar el tw_windowModal (siempre modal) --}}
  <button wire:click="toggleWindowModal" class="bg-blue-500 text-white px-4 py-2 rounded-md">
    Abrir Ventana Modal
  </button>

  {{-- Botón para mostrar el tw_window (no modal) --}}
  <button wire:click="toggleWindow" class="bg-green-500 text-white px-4 py-2 rounded-md ml-4">
    Abrir Ventana No Modal
  </button>

  {{-- Componente tw_windowModal (siempre modal) --}}
  @isset($showWindowModal)
  @if ($showWindowModal)
  <x-forms.tw_windowModal title="Ventana Modal" width="w-98">
    <p>Este es el contenido de la ventana modal, centrado en la pantalla con fondo oscuro.</p>
    <x-slot name="footer">
      <button wire:click="toggleWindowModal" class="bg-red-500 text-white px-4 py-2 rounded-md">Cerrar</button>
    </x-slot>
  </x-forms.tw_windowModal>
  @endif
  @endisset
  {{-- Componente tw_window (no modal, centrado dentro del contenedor) --}}
  @isset($showWindow)
  @if ($showWindow)
  <x-forms.tw_window title="Ventana No Modal" width="w-80">
    <p>Este es el contenido de la ventana no modal. Está centrado en el contenedor.</p>
    <x-slot name="footer">
      <button wire:click="toggleWindow" class="bg-green-500 text-white px-4 py-2 rounded-md">Cerrar</button>
    </x-slot>
  </x-forms.tw_window>
  @endif
  @endisset
</div>