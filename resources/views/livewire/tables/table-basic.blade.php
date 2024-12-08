<div>
  @forelse ($datas as $data )
  {{ $data->id }}, {{ $data->nombres }}
  @empty
  debe mostrar la tabla
  @endforelse
</div>