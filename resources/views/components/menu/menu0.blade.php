@php
$menus=[
'acerca de'=>['route'=>'acercade','icon'=>''],
'contacto'=>['route'=>'contacto','icon'=>'contacto'],
'iconos'=>['route'=>'iconos','icon'=>'iconos'],
'pruebas'=>['route'=>'pruebas','icon'=>'pruebas']
];
@endphp
@foreach ($menus as $title=>$menu)
{{-- @dd($menu) --}}
<x-nav-link :href="route($menu['route'])" :active="request()->routeIs($menu['route'])"
  class="text-xs whitespace-nowrap">
  @isset($menu['icon'])
  <x-forms.tw_icons name="{{ $menu['icon'] }}" :error=false />
  @endisset
  {{ __($title) }}
</x-nav-link>

{{-- <x-nav-link :href=" route($menu['route'])" :active="request()->routeIs($menu['active'])">
  {{ __($menu['titulo']) }}
</x-nav-link> --}}

@endforeach