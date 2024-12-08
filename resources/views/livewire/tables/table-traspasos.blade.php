<div>
  <table class="table-auto w-full">
    <thead>
      <tr>
        <th>ID</th>
        <th>Fecha</th>
        <th>Descripción</th>
        <th>Euros</th>
        {{-- <th>Francos</th> --}}
        <th>Archivo</th>
        <th>ID Movimiento</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($data as $row)
      <tr>
        <td class="border border-gray-300 px-2 py-0">{{ $row->id ?? 'N/A' }}</td>
        <td class="border border-gray-300 px-2 py-0">{{ $row->date ?? 'N/A' }}</td>
        <td class="border border-gray-300 px-2 py-0">{{ $row->libelle ?? 'N/A' }}</td>
        <td class="border border-gray-300 px-2 py-0 text-right">{{ $row->montantEUROS ?? '0.00' }}</td>
        {{-- <td class="border border-gray-300 px-2 py-0 text-right">{{ $row->montantFRANCS ?? '0.00' }}</td> --}}
        <td class="border border-gray-300 px-2 py-0">{{ $row->NomArchTras ?? 'Sin Archivo' }}</td>
        <td class="border border-gray-300 px-2 py-0">{{ $row->idArchMov ?? 'Pendiente' }}</td>
      </tr>
      @endforeach
    </tbody>
  </table>

  <div class="mt-4">
    {{ $data->links() }}
  </div>
</div>