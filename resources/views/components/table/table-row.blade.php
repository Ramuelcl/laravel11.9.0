{{-- resources/views/components/table/table-row.blade.php --}}
<tr>
  @foreach ($campos as $campo)
  <td class="border px-4 py-2">{{ $item->$campo }}</td>
  @endforeach
</tr>