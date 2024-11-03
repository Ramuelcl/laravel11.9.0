{{-- resources/views/principal/iconos.blade.php --}}
<x-app-layout>
  <x-slot name="header">
    {{ __('Icons') }}
    {{-- <div class="mt-2 font-normal">
      <a class="rounded bg-blue-500 px-4 py-1 text-white"
         href="{{ route('iconos', ['typeIcon' => 'outline']) }}">Outline</a>
      <a class="rounded bg-blue-500 px-4 py-1 text-white"
         href="{{ route('iconos', ['typeIcon' => 'solid']) }}">Solid</a>
    </div> --}}
  </x-slot>

  <div class="mb-4 flex items-center justify-between">
    <div class="mt-2 flex flex-wrap">
      @foreach ($svgIcons as $svgIcon)
        <div class="m-2 flex flex-col items-center rounded-lg border-2 border-blue-400 p-2">
          <x-forms.tw_icons class="mb-2 h-8 w-8"
                            :name="$svgIcon" />
          <span>{{ $svgIcon }}</span>
        </div>
      @endforeach
    </div>
</x-app-layout>
