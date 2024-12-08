{{-- resources/views/components/table/table-header.blade.php --}}
@props(['titles' => ['titulos NO enviados']])
<thead>
  <tr>
    @foreach ($titles as $title)
    <th class="text-center border px-4 py-2">{{ $title }}</th>
    @endforeach
  </tr>
</thead>