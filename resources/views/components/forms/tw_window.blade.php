{{-- resources/views/components/tw_window.blade.php --}}
@props(['width' => 'w-96', 'title' => 'Title of window', 'modal' => false])

<div class="fixed inset-0 flex items-center justify-center z-50" id="modalContainer" style="display: none;">
  {{-- Fondo Oscuro Semitransparente para modo modal --}}
  @if ($modal)
  <div class="fixed inset-0 bg-black opacity-50" id="overlay"></div>
  @endif

  <div class="border border-gray-300 rounded-md shadow-lg bg-white dark:bg-gray-800 {{ $width }} relative z-10"
    id="ventana">
    <div class="bg-blue-500 px-4 py-2 rounded-t-md flex items-center justify-between">

      {{-- Título --}}
      <span class="text-white font-semibold text-lg">{{ __($title) }}</span>

      <div class="ml-auto space-x-2">
        {{-- Ícono de cerrar con id="cerrarBtn" --}}
        <x-forms.tw_icons id="cerrarBtn" name="x" class="text-gray-50 cursor-pointer" />
      </div>
    </div>
    <div class="p-4">
      <!-- Contenido de la ventana -->
      {{ $slot }}
    </div>
    @isset($footer)
    <div class="bg-gray-100 px-4 py-2 rounded-b-md border-t-2 flex justify-end space-x-2">
      {{ $footer }}
    </div>
    @endisset
  </div>
</div>

<script>
  // Obtener los elementos del DOM
  const cerrarBtn = document.getElementById('cerrarBtn');
  const ventana = document.getElementById('ventana');
  const modalContainer = document.getElementById('modalContainer');
  const overlay = document.getElementById('overlay');

  // Función para mostrar el modal
  function abrirModal(isModal = true) {
    modalContainer.style.display = 'flex';

    // Si es modal, muestra el overlay y permite cerrar al hacer clic fuera
    if (isModal && overlay) {
      overlay.style.display = 'block';
      overlay.addEventListener('click', cerrarModal);
    } else {
      // En caso contrario, oculta el overlay y no permite cerrar al hacer clic fuera
      if (overlay) overlay.style.display = 'none';
    }
  }

  // Función para cerrar el modal
  function cerrarModal() {
    modalContainer.style.display = 'none';
  }

  // Añadir evento para cerrar la ventana al hacer clic en cerrarBtn
  cerrarBtn.addEventListener('click', cerrarModal);
</script>