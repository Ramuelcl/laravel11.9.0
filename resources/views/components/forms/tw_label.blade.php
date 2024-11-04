{{-- resources/views/components/forms/tw_label.blade.php --}}

@props(['id' => '', 'name' => '', 'class' => ''])

<label for="{{ $id ?? $name }}" {{ $attributes->merge(['class' => 'block text-sm font-medium leading-6 text-gray-900
  rounded-md' . $class]) }}
  >
  {{ $slot }}
</label>