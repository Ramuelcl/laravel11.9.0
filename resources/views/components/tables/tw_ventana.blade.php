<div class="max-w-2xl mx-auto bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden border">
  <!-- Cabecera fija -->
  <div class="px-4 py-2 bg-gray-200 dark:bg-gray-700">
    <h2 class="text-lg font-semibold text-gray-900 dark:text-white text-center">
      {{ $title ?? 'Título de la Ventana' }}
    </h2>
  </div>

  <!-- Contenido principal -->
  <div class="p-4" style="height: 300px; overflow-y: auto;">
    <!-- Aquí va el contenido pasado como slot -->
    {{ $slot }}
  </div>

  <!-- Pie con paginación -->
  <div class="px-4 py-2 bg-gray-100 dark:bg-gray-700">
    {{ $pagination ?? '' }}
  </div>
</div>