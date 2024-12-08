{{-- resources/views/livewire/travail/clientes.blade.php --}}
<div>
  @if($open === true)
  <div class="bg-lightBg shadow rounded-lg p-6">
    <form action="">
      {{-- --}}
    </form>
  </div>
  @livewire('travail.clientes-form', ['fields' => $fields])
  @else
  @livewire('tables.tableBasic', [
  'model' => \App\Models\backend\Entidad::class,
  'fields' => $fields,
  'filters' => $filters,
  'perPage' => 10
  ])
  @endif
</div>