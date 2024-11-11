<x-guest-layout>
  <form method="POST" action="{{ route('register') }}">
    @csrf

    <!-- Name -->
    <div>
      <x-forms.tw_input label="{{ __('Name') }}" name="name" placeholder="Input Name" :value="old('name')" required
        autofocus autocomplete="name" />
    </div>

    <!-- Email Address -->
    <div class="mt-4">
      <x-forms.tw_input label="email" :value="__('Email')" id="email" type="email" name="email" :value="old('email')"
        required autocomplete="name" placeholder="Input eMail" />
    </div>

    <!-- Password -->
    <div class="mt-4">
      <x-forms.tw_input label="password" id="password" type="password" name="password" required
        autocomplete="new-password" placeholder="{{ __('Password') }}" />
    </div>

    <!-- Confirm Password -->
    <div class="mt-4">
      <x-forms.tw_input label="password_confirmation" id="password_confirmation" type="password"
        name="password_confirmation" required autocomplete="new-password" placeholder="{{ __('retipe password') }}" />
    </div>

    <div class="flex items-center justify-end mt-4">
      <a class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
        href="{{ route('login') }}">
        {{ __('Already registered?') }}
      </a>
      <x-forms.tw_button color="blue" class="ms-4">
        {{ __('Register') }}
      </x-forms.tw_button>

    </div>
  </form>
</x-guest-layout>