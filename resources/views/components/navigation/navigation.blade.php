<!--
resources/views/livewire/forms/navigation.blade.php
app/livewire/forms/Navigation.php
-->
<nav class="bg-lightBg dark:bg-darkBg border-b-2 border-lightText dark:border-darkText" x-data="{ open: false }">
  <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
    <div class="relative flex h-16 items-center justify-between">

      <!-- Mobile menu button-->
      <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
        <button type="button" x-on:click="open = true"
          class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-slate-500 hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white"
          aria-controls="mobile-menu" aria-expanded="false">
          <span class="absolute -inset-0.5"></span>
          <span class="sr-only">Open main menu</span>
          <!--
            Icon when menu is closed.

            Menu open: "hidden", Menu closed: "block"
          -->
          <svg class="block h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            aria-hidden="true" data-slot="icon">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
          </svg>
          <!--
            Icon when menu is open.

            Menu open: "block", Menu closed: "hidden"
          -->
          <svg class="hidden h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            aria-hidden="true" data-slot="icon">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
          </svg>
        </button>
      </div>

      <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
        <!--logotipo-->
        <div class="flex flex-shrink-0 items-center">
          <img class="h-8 w-auto" src="https://tailwindui.com/plus/img/logos/mark.svg?color=indigo&shade=500"
            alt="Your Company">
        </div>

        <!-- menu principal LG-->
        <div class="hidden sm:ml-6 sm:block">
          <div class="flex space-x-4">
            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
            <a href="#" class="rounded-md bg-gray-900 px-3 py-2 text-sm font-medium hover:bg-slate-500 text-white"
              aria-current="page">Dashboard</a>
            <a href="#"
              class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-slate-500 hover:text-white">Team</a>
            <a href="#"
              class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-slate-500 hover:text-white">Projects</a>
            <a href="#"
              class="rounded-md px-3 py-2 text-sm font-medium text-gray-300 hover:bg-slate-500 hover:text-white">Calendar</a>
          </div>
        </div>
      </div>

      <!-- notificaciones / usuario / dark-light / idioma -->
      <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">

        <!-- boton notificacion-->
        <button type="button"
          class="relative rounded-full bg-gray-800 p-1 text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800">
          <span class="absolute -inset-1.5"></span>
          <span class="sr-only">View notifications</span>
          <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            aria-hidden="true" data-slot="icon">
            <path stroke-linecap="round" stroke-linejoin="round"
              d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
          </svg>
        </button>

        <!-- Profile dropdown -->
        <div class="relative ml-3" x-data="{ open: false }">
          <div>
            <button type="button" x-on:click="open = true"
              class="relative flex rounded-full bg-gray-800 text-sm focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-gray-800"
              id="user-menu-button" aria-expanded="false" aria-haspopup="true">
              <span class="absolute -inset-1.5"></span>
              <span class="sr-only">Open user menu</span>
              <img class="h-8 w-8 rounded-full"
                src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                alt="">
            </button>
          </div>

          <!--            Dropdown menu, show/hide based on menu state. -->
          <div x-show="open" x-on:click.away="open = false"
            class=" absolute right-0 z-10 mt-2 w-48 origin-top-right rounded-md py-1 shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none bg-lightBg dark:bg-darkBg text-lightText dark:text-darkText shadow-darkBg dark:shadow-lightBg"
            role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
            <!-- Active: "bg-gray-100", Not Active: "" -->
            <a href="#" class="block px-4 py-2 text-sm hover:bg-slate-500" role="menuitem" tabindex="-1"
              id="user-menu-item-0">Profile</a>
            <a href="#" class="block px-4 py-2 text-sm hover:bg-slate-500" role="menuitem" tabindex="-1"
              id="user-menu-item-1">Settings</a>
            <a href="#" class="block px-4 py-2 text-sm hover:bg-slate-500" role="menuitem" tabindex="-1"
              id="user-menu-item-2">Sign out</a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- menu Mobile -->
  <div class="hidden" id="mobile-menu" x-show="open" x-on:click.away="open = false"
    x-transition:enter="transition ease-out duration-200"
    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="transition ease-in duration-75"
    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
    <div class="space-y-1 px-2 pb-3 pt-2">
      <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-slate-500 hover:text-white" -->
      <a href="#" class="block rounded-md bg-gray-900 px-3 py-2 text-base font-medium text-white"
        aria-current="page">Dashboard</a>
      <a href="#"
        class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-slate-500 hover:text-white">Team</a>
      <a href="#"
        class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-slate-500 hover:text-white">Projects</a>
      <a href="#"
        class="block rounded-md px-3 py-2 text-base font-medium text-gray-300 hover:bg-slate-500 hover:text-white">Calendar</a>
    </div>
  </div>
</nav>