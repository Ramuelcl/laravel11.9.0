@props(['width'=>'w-96', 'title'=>'Title of window'])
<div class="fixed inset-0 flex items-center justify-center z-50">
  {{--resources/views/components/forms/tw_window.blade.php --}}
  <div class="w- border border-gray-300 rounded-md shadow-lg {{ $width }} relative" id="ventana">
    <div class="bg-blue-500 px-4 py-2 rounded-t-md flex items-center justify-between">

      {{-- titulo --}}
      <span class="text-white font-semibold text-lg">{{__( $title)}}</span>

      <div class="ml-auto space-x-2">
        <x-forms.tw_icons name="x" class="text-gray-50" />
      </div>
    </div>
    <div class="p-4">
      <!-- Contenido de la ventana -->
      {{ $slot }}
    </div>
    @isset($footer)
    <div class=" bg-gray-100 px-4 py-2 rounded-b-md border-t-2 flex justify-end space-x-2">
      {{ $footer }}
    </div>
    @endisset
  </div>
</div>

<script>
  // Obtener los elementos del DOM
  const minimizarBtn = document.getElementById('minimizarBtn');
  const maximizarBtn = document.getElementById('maximizarBtn');
  const cerrarBtn = document.getElementById('cerrarBtn');
  const ventana = document.getElementById('ventana');
  const contenidoVentana = document.querySelector('#ventana > div:nth-child(2)'); // Selecciona el segundo div hijo de #ventana

  let ventanaMaximizada = false; // Variable para rastrear el estado de maximización

  // Añadir eventos a los botones
minimizarBtn.addEventListener('click', () => {
contenidoVentana.classList.toggle('hidden'); // Oculta/muestra el contenido

// Ajusta el ancho de la ventana y el icono del botón
if (ventana.classList.contains('w-96')) {
ventana.classList.replace('w-96', 'w-1/2'); // Cambia a 50% de ancho
minimizarBtn.innerHTML = '□'; // Cambia el icono a un cuadrado
} else {
ventana.classList.replace('w-1/2', 'w-96'); // Vuelve al ancho original
minimizarBtn.innerHTML = '-'; // Vuelve al icono de minimizar
}
});

  maximizarBtn.addEventListener('click', () => {
    if (ventanaMaximizada) {
      // Restaurar tamaño original
      ventana.classList.remove('w-screen', 'h-screen', 'rounded-none');
      ventana.classList.add('w-96', 'rounded-md');
      ventanaMaximizada = false;
    } else {
      // Maximizar ventana
      ventana.classList.remove('w-96', 'rounded-md');
      ventana.classList.add('w-screen', 'h-screen', 'rounded-none');
      ventanaMaximizada = true;
    }
  });

  cerrarBtn.addEventListener('click', () => {
    ventana.style.display = 'none'; // Oculta la ventana completamente
  });
</script>