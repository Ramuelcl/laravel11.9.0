<div class="w-full h-16 z-30 sticky top-0 shadow-sm">
  <nav x-data="{
  q='',
  focus(){
  this.$refs.q0.focus();
  {{-- this.$refs.q1.focus() --}}
}}" @keydown.window.prevent.ctrl.k="focus()">

    <div
      class="z-20 w-full transition duration-200 ease-in-out border-b dark:border-darkText/20 border-lightText/20 bg-lightBg dark:bg-darkBg">
      <div
        class="flex items-center justify-between w-full h-full mx-auto max-w-screen-3xl px-4 md:px-6  lg:justify-center lg:px-8 2xl:px-10">
        <a wire:navigate href="{{ route('inicio') }}">
          <x-header.logo showText="{{ config('guzanet.appEmpresa') }}" class="mx-2" />
        </a>
        <div class="flex-1 flex">
          <div class="w-full gap-8 hidden mx-auto lg:flex lg:max-w-[385px] xl:maw-w-[530px] 2xl:max-w-[700px]">
            @php
            $menus=[
            'acerca de'=>['route'=>'acercade','icon'=>'','titulo'=>'Acerca de...'],
            'contacto'=>['route'=>'contacto','icon'=>'contacto','titulo'=>'contacto'],
            'iconos'=>['route'=>'iconos','icon'=>'iconos','titulo'=>'iconos'],
            'pruebas'=>['route'=>'pruebas','icon'=>'pruebas','titulo'=>'pruebas'],
            ];
            @endphp
            @foreach ($menus as $title=>$menu)
            {{-- @dd($menu) --}}
            <x-nav-link :href="route($menu['route'])" :active="request()->routeIs($menu['route'])">
              @isset($menu['icon'])
              <x-forms.tw_icons name="{{ $menu['icon'] }}" :error=false />
              @endisset
              {{ __($title) }}
            </x-nav-link>

            {{-- <x-nav-link :href=" route($menu['route'])" :active="request()->routeIs($menu['active'])">
              {{ __($menu['titulo']) }}
            </x-nav-link> --}}

            @endforeach
            {{--
            <x-navigation.searchBar /> --}}
          </div>
          <div class="flex gap-3 ml-auto items-center">
            <x-menu.theme />
            <x-menu.user />
          </div>
        </div>
      </div>
  </nav>
</div>