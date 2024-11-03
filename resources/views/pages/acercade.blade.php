<x-app-layout>
  <div class="flex content-between justify-between">
    <h2 class="font-extrabold"> {{ __('Acerca de...') }}</h2>

  </div>
  <div>
    <button type="button"
            onclick="redirigir">ir a Dashboard</button>
  </div>
  <div>
    <div class="border-b border-gray-200 p-6">
      {{ __('acerca de mi') }}
    </div>
  </div>
</x-app-layout>
