@isset($footer)
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
  {{ $footer }}
</div>
@else
<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
  @yield('footer')
</div>
@endisset
<strong>Copyright &copy; 2014-2024 <a href="#">Guzanet</a>.</strong> All rights reserved.