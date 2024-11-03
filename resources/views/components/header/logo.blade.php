@props(['showText'])

<div>
  <div class="flex gap-1 items-center">
    {{-- <img src="public/app/logo/Guzanet.png" alt="LoGo" width="24px" height="24px" {{$attributes }}> --}}

    <img src="{{ asset(config('guzanet.appLogo')) }}" alt="" {{ $attributes->merge(['class' => 'w-10 h-10 px-2'])}}>
    @isset($showText)
    <div class="hidden md:flex font-extrabold text-xl text-emerald-600 dark:text-emerald-400">{{ $showText}}</div>
    @endisset
  </div>
</div>