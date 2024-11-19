<?php
// app/Imports/TraspasoBancaImport.php

namespace App\Imports;

use App\Models\TraspasoBanca;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TraspasoBancaImport implements ToModel, WithHeadingRow
{
    /**
     * Transformar cada fila del archivo importado a un modelo.
     *
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new TraspasoBanca([
            'campo1' => $row['campo1'],  // Asegúrate de usar el nombre de la columna correcto
            'monto'  => $row['monto'],
            'fecha'  => \Carbon\Carbon::parse($row['fecha']),
        ]);
    }
}
