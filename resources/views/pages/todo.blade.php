<x-app-layout>
  <div class="flex content-between justify-between">
    <h2 class="font-extrabold"> {{ __('To Do') }}</h2>
  </div>
  <div>
    <div>
      <div class="border-b border-gray-200 p-6">
        @livewire('todo.lwindex')
      </div>
    </div>
</x-app-layout>
