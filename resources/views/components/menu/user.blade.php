<div class="relative inline-block">
  @guest
  <div class="flex gap-2 p-2 rounded text-xs">
    <a wire:navigate href="{{ route('register') }}" class="flex gap-2">
      <span> {{ __('Register') }}</span>
    </a>
    <div class="border-r dark:border-gray-700"></div>
    <a wire:navigate href="{{ route('login') }}" class="flex gap-2">
      <span> {{ __('Login') }}</span>
    </a>
  </div>
  @endguest

  @auth

  @endauth
</div>