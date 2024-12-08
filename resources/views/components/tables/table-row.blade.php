{{-- resources/views/components/table/table-row.blade.php --}}
@props(['item'=>null, 'fields'=>null])
{{-- @dd($item, $fields) --}}
<tr>
  @foreach ($fields as $id => $field)
  @php
  $list=$this->getField($id, 'list');
  $type=$this->getField($id, 'type');
  $dec=$this->getField($id, 'decimal', 0);
  // dd(['value'=>$value,'display'=>$list, 'type'=>$type,'id'=> $id,'field'=> $field]);
  @endphp
  @if($list)
  @php
  $value = $item[$id] ?? null; // Accede al valor usando el identificador del campo
  $value = mb_check_encoding($value, 'UTF-8') ? $value : utf8_encode($value);
  @endphp
  <td class="border px-4 py-1 text-gray-900 dark:text-white">
    @switch($type)
    @case('integer')
    @case('decimal')
    <div class="text-right">
      {{ number_format($value, $dec, '.', ',') ?? 'N/A'}}
    </div>
    @break

    @case('date')
    <div class="text-center">
      {{ date('d/m/Y', strtotime($value)) ?? 'N/A'}}
    </div>
    @break

    @case('checkit')
    <div class="text-center">
      {{ $value ? 'yes' : 'no' }}
    </div>
    @break

    @case('image')
    <div class="text-center w-10 h-10">
      @if (Storage::disk('public')->exists($value))
      <img src="{{ asset('storage/' . $value) }}" alt="Foto">
      @endif

    </div>
    @break

    @default
    <div class="text-left">
      {{ $value ?? 'N/A'}}
    </div>
    @endswitch
  </td>
  @endif
  @endforeach
</tr>