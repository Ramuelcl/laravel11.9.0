@include('layouts.includes.head')

<body class="font-sans text-gray-900 antialiased">
  <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
    <div>
      <a wire:navigate href="{{ route('inicio') }}">
        <x-header.logo showText="{{ config('guzanet.appEmpresa') }}" class="mx-2" />
      </a>
    </div>

    <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
      {{ $slot }}
    </div>
  </div>
</body>

</html>