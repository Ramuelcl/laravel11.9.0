{{-- resources/views/livewire/travail/clientes.blade.php --}}
<div>
  {{-- @if($open === true) --}}
  <x-tables.tw_ventana title="{{__( $accion .' Cliente')}}">
    <div class="bg-lightBg dark:bg-darkBg shadow rounded-lg">
      <div class="container mx-auto sm:px-4">
        <form>
          @csrf
          {{-- <x-forms.tw_button color="blue" wire:click="crear">+</x-forms.tw_button> --}}
          <fieldset {{ $accion=='eliminar' ? 'disabled' : '' }}>
            <div class="flex-auto p-2 space-y-2 grid grid-cols-2 gap-4">
              <div class="col-span-1">
                {{-- tipoEntidad, no modificable --}}
                <div>
                  <x-forms.tw_input type="select" :options="$tiposEntidad" label="Tipo" :disabled="true"
                    class="w-[200px]" value="{{ 2 ?? old('tipoEntidad') }}" />
                </div>
                {{-- nombres --}}
                <div>
                  <x-forms.tw_input type="text" label="Nombre(s)" placeholder="Ingrese el nombre" wire:model="nombres"
                    value="{{ $value ?? old('nombres') }}" />
                </div>
                {{-- apellidos --}}
                <div>
                  <x-forms.tw_input type="text" label="Apellido(s)" placeholder="Ingrese apellidos"
                    wire:model="apellidos" value="{{ $value ?? old('apellidos') }}" />
                </div>
                {{-- razonSocial --}}
                <div>
                  <x-forms.tw_input type="text" label="Razon Social" placeholder="Ingrese razonSocial"
                    wire:model="razonSocial" labelPosition="right" value="{{ $value ?? old('razonSocial') }}" />
                </div>
              </div>
              {{-- fin primera columna --}}
              {{-- inicio segunda columna --}}
              {{-- Categorias --}}
              <div>
                <x-forms.tw_input type="select" :options="$categorias" label="Categoria" wire:model="categoria_id"
                  class="w-[200px]" value="{{ $value ?? old('categoria_id') }}" />
              </div>

              {{-- Marcadores --}}
              <div>
                <caption>Marcadores</caption>
                <x-forms.tw_input type="checkbox" :options="$marcadores" label="Marcadores" wire:model="marcadores_id"
                  multiple class="w-[200px]" value="{{ $value ?? old('marcadores_id') }}" />
              </div>

              <div class="col-span-2">
                <div class="mb-3">
                  <label for="image" class="form-label h4">Image</label>
                  <input type="file"
                    class="@error('image') bg-red-700 @enderror py-2 px-4 text-lg leading-normal rounded"
                    placeholder="Image" name="image">
                  @error('image')
                  <p class="hidden mt-1 text-sm text-red">{{ $message }}</p>
                  @enderror
                </div>
              </div>
              {{-- fin segunda columna --}}
            </div> {{-- fin de columnas --}}
          </fieldset>
          <div class="justify-between">
            <button wire:click="save"
              class="inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded no-underline py-3 px-4 leading-tight text-xl bg-blue-600 text-white hover:bg-blue-600">{{
              __('Save') }}</button>

          </div>
        </form>
      </div>
    </div>
  </x-tables.tw_ventana>
  {{-- @livewire('travail.clientes-form', ['fields' => $fields]) --}}
  {{-- @else
  @livewire('tables.tableBasic', [
  'model' => $datas,
  'fields' => $fields,
  'filters' => $filters,
  'perPage' => 10
  ])
  @endif --}}
</div>