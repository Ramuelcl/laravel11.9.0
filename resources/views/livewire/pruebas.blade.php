{{-- resources/views/livewire/pruebas.blade.php --}}
<div>
  <x-forms.tw_mensajes />
  <x-forms.tw_window title="probando Input en formularios" position="absolute left-40">
    <form class="mt-4" wire:submit.prevent="submitForm">
      {{-- Ejemplo de campo de texto --}}
      <x-forms.tw_input id="username" name="username" label="Nombre de usuario" />

      {{-- Ejemplo de campo de contraseña con mostrar/ocultar --}}
      <x-forms.tw_input id="password" name="password" label="Contraseña" type="password" />

      {{-- Ejemplo de checkbox --}}
      <x-forms.tw_input id="agree" name="agree" label="Acepto los términos" type="checkbox" />

      {{-- Ejemplo de select --}}
      <x-forms.tw_input id="gender" name="gender" label="Género" type="select"
        :options="['male' => 'Masculino', 'female' => 'Femenino']" />
    </form>

    {{-- Footer para los botones de acción del formulario --}}
    <x-slot name="footer">
      <button type="submit" form="username" class="bg-blue-500 text-white px-4 py-2 rounded-md">Enviar</button>
      <button type="button" onclick="" class="bg-red-500 text-white px-4 py-2 rounded-md">Cancelar</button>
    </x-slot>
  </x-forms.tw_window>
</div>