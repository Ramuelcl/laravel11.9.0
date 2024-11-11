@php
$menus=[
'Blog'=>['route'=>'blog','icon'=>''],
'Portfolio'=>['route'=>'portfolio','icon'=>''],
// 'iconos'=>['route'=>'iconos','icon'=>'iconos'],
// 'pruebas'=>['route'=>'pruebas','icon'=>'pruebas'],
];
@endphp
@foreach ($menus as $title=>$menu)
<x-nav-link :href="route($menu['route'])" :active="request()->routeIs($menu['route'])">
  @isset($menu['icon'])
  <x-forms.tw_icons name="{{ $menu['icon'] }}" :error=false />
  @endisset
  {{ __($title) }}
</x-nav-link>
@endforeach
<div @click.away="open = false" class="relative" x-data="{ open: false }">
  <button @click="open = !open"
    class="focus:shadow-outline mt-2 flex w-full flex-row items-center  text-lefthover:bg-gray-200 hover:text-gray-900 focus:bg-gray-200 focus:text-gray-900 focus:outline-none md:mt-0 md:ml-4 md:inline md:w-auto">
    <span>Dropdown</span>
    <svg fill="currentColor" viewBox="0 0 20 20" :class="{'rotate-180': open, 'rotate-0': !open}"
      class="mt-1 ml-1 inline h-4 w-4 transform transition-transform duration-200 md:-mt-1">
      <path fill-rule="evenodd"
        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
        clip-rule="evenodd"></path>
    </svg>
  </button>
  <div x-show="open" x-transition:enter="transition ease-out duration-100"
    x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100"
    x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100"
    x-transition:leave-end="transform opacity-0 scale-95"
    class="absolute right-0 mt-2 w-full origin-top-right rounded-md shadow-lg md:w-48">
    <div class="rounded-md bg-gray-800 px-2 py-2 shadow">
      <a class="focus:shadow-outline mt-2 block text-gray-200 hover:bg-gray-200 hover:text-gray-900 focus:bg-gray-200 focus:text-gray-900 focus:outline-none md:mt-0"
        href="#">Link #1</a>
      <a class="focus:shadow-outline mt-2 block text-gray-200 hover:bg-gray-200 hover:text-gray-900 focus:bg-gray-200 focus:text-gray-900 focus:outline-none md:mt-0"
        href="#">Link #2</a>
      <a class="focus:shadow-outline mt-2 block text-gray-200 hover:bg-gray-200 hover:text-gray-900 focus:bg-gray-200 focus:text-gray-900 focus:outline-none md:mt-0"
        href="#">Link #3</a>
      <a class="focus:shadow-outline mt-2 block text-gray-200 hover:bg-gray-200 hover:text-gray-900 focus:bg-gray-200 focus:text-gray-900 focus:outline-none md:mt-0"
        href="https://laraveltuts.com">LaravelTuts</a>
    </div>
  </div>
</div>