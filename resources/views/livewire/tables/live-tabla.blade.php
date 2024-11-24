<table class="table">
  <x-table.table-header :titulos="$titulos" />
  <tbody>
    @foreach ($data as $item)
    <x-table.table-row :item="$item" :campos="$campos" />
    @endforeach
  </tbody>
</table>