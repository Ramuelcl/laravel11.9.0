<div>
  <!-- Para encabezado, puedes utilizar la propiedad $header en el controlador si es necesario -->
  <form class="mt-4" wire:submit.prevent="submitForm">
    <div class="mb-4">
      <label for="name">Nombre:</label>
      <input type="text" id="name" wire:model="name" class="block w-full border-gray-300 rounded-md" required>
    </div>

    <div class="mb-4">
      <label for="email">Email:</label>
      <input type="email" id="email" wire:model="email" class="block w-full border-gray-300 rounded-md" required>
    </div>

    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md">Enviar</button>
  </form>
</div>