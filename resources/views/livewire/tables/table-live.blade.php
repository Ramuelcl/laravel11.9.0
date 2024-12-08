{{-- resources/views/livewire/tables/table-live.blade.php --}}
<div class="my-2">
  <table class="table">
    <div class="justify-between">
      <x-forms.tw_button>+</x-forms.button>
        <x-forms.tw_button>-</x-forms.button>
    </div>
    @if (!empty($titles))
    <x-table.table-header :titles="$titles" />
    @else
    <thead>
      <tr>
        <th class="text-center">No hay títulos disponibles</th>
      </tr>
    </thead>
    @endif
    <tbody>
      {{-- @dd($data) --}}
      @forelse ($data as $item)
      <x-table.table-row :item="$item" :fields="$fields" />
      @empty
      <tr>
        <td colspan="{{ count($titles) }}" class="text-center">No hay datos disponibles</td>
      </tr>
      @endforelse
    </tbody>
  </table>
  <div class="border-green-300 py-2 border-y-2">
    @if(!is_array($data))
    {{ $data->links() ?? null}}
    @endif
  </div>
</div>