{{-- resources/views/components/forms/tw_input.blade.php --}}
@props([
'disabled' => false,
'type' => 'text',
'label' => null,
'id' => '',
'name' => '',
'value' => null,
'class' => '',
'classFix' => 'font-normal text-blue-500 dark:text-blue-100 block rounded-md form-input border-blue-400
focus:border-blue-600 mb-3',
'options' => [], // Para el tipo select
'labelPosition' => 'left', // Posición del label: left, up, right, down
'labelWidth' => 'w-1/3', // Ancho máximo del label (predeterminado)
'inputWidth' => 'w-full', // Ancho máximo del input (predeterminado)
])

{{-- Contenedor flexible para el label y el input --}}
<div class="
    @if($labelPosition === 'up') flex flex-col space-y-1 
    @elseif($labelPosition === 'down') flex flex-col-reverse space-y-1 
    @else grid grid-cols-12 gap-4 items-center @endif w-full
">
  {{-- Etiqueta --}}
  @if ($label)
  <label for="{{ $id ?? $name }}" class="text-sm text-gray-700 dark:text-gray-200 
               @if($labelPosition === 'left') sm:col-span-3 text-left {{ $labelWidth }} @endif
               @if($labelPosition === 'right') sm:col-span-3 text-right {{ $labelWidth }} @endif
               @if($labelPosition === 'up') block mb-1 w-full @endif
               @if($labelPosition === 'down') block mt-1 w-full @endif
               whitespace-nowrap">
    {{ $label }}
  </label>
  @endif

  {{-- Input según el tipo --}}
  <div class="@if($labelPosition !== 'up') sm:col-span-9 {{ $inputWidth }} @endif">
    @if ($type == 'textarea')
    <textarea id="{{ $id ?? $name }}" name="{{ $name }}" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => "$classFix $class w-full"]) !!}>
                {{ $value }}
            </textarea>
    @elseif ($type == 'checkbox')
    @foreach ($options as $ind=>$option)
    <label>
      <input id="{{ $id ?? $name }}" name="{{ $name[] }}" type="checkbox" value="{{ $ind }}" {{ $disabled ? 'disabled'
        : '' }} {!! $attributes->merge(['class' => "$classFix $class"]) !!} />{{ $option }}
    </label>
    @endforeach
    @elseif ($type == 'select')
    <select id="{{ $id ?? $name }}" name="{{ $name }}" {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class'
      => "$classFix $class w-full"]) !!}>
      <option value="" disabled>Seleccione</option>
      @foreach ($options as $key => $option)
      <option value="{{ $key }}" {{ $value==$key ? 'selected' : '' }}>{{ $option }}</option>
      @endforeach
    </select>
    @elseif ($type == 'password')
    {{-- <div class="relative">
      <div x-data="{ showPass:false }" class="relative">
        <input id="{{ $id ?? $name }}" name="{{ $name }}" :type="showPass ? 'text' : 'password'" value="{{ $value }}" {{
          $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => "$classFix $class w-full"]) !!} />
        <button type="button" @click="showPass = !showPass"
          class="absolute inset-y-0 right-0 px-3 text-gray-500 focus:outline-none">
          <x-forms.tw_icons :name="showPass ? 'eye-slash' : 'eye'" />
        </button>
      </div>
    </div> --}}
    <div class="relative">
      <input id="{{ $id ?? $name }}" name="{{ $name }}" type="password" value="{{ $value }}" {{ $disabled ? 'disabled'
        : '' }} {!! $attributes->merge(['class' => "$classFix $class w-full"]) !!} />
      <button type="button" onclick="togglePasswordVisibility('{{ $id ?? $name }}')"
        class="absolute inset-y-0 right-0 px-3 text-gray-500 focus:outline-none">
        <x-forms.tw_icons id="icon-{{ $id ?? $name }}" name="eye" />
      </button>
    </div>
    @else
    <input id="{{ $id ?? $name }}" name="{{ $name }}" type="{{ $type }}" value="{{ $value }}" {{ $disabled ? 'disabled'
      : '' }} {!! $attributes->merge(['class' => "$classFix $class w-full"]) !!} />
    @endif
  </div>
</div>

{{-- Script para mostrar/ocultar la contraseña --}}
<script>
  function togglePasswordVisibility(inputId) {
        const inputField = document.getElementById(inputId);
        const icon = document.getElementById('icon-' + inputId);

        if (inputField.type === 'password') {
            inputField.type = 'text';
            icon.classList.add('text-blue-600');
        } else {
            inputField.type = 'password';
            icon.classList.remove('text-blue-600');
        }
    }
</script>
{{--
1. Diseño Horizontal (Label a la Izquierda)
<x-forms.tw_input id="nombre" name="nombre" label="Nombre Completo" labelWidth="w-1/4" inputWidth="w-3/4" />
2. Diseño Horizontal (Label a la Derecha)
<x-forms.tw_input id="correo" name="correo" label="Correo Electrónico" labelPosition="right" labelWidth="w-1/5"
  inputWidth="max-w-lg" />
3. Diseño Vertical (Label Arriba)
<x-forms.tw_input id="telefono" name="telefono" label="Teléfono" labelPosition="up" />
4. Diseño Vertical (Label Abajo)
<x-forms.tw_input id="telefono" name="telefono" label="Teléfono" labelPosition="down" />
--}}