{{-- resources/views/components/table/table-header.blade.php --}}
<thead>
  <tr>
    @foreach ($titulos as $titulo)
    <th class="text-center border px-4 py-2">{{ $titulo }}</th>
    @endforeach
  </tr>
</thead>