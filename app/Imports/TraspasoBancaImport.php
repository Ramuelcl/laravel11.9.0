<?php

namespace App\Imports;

use App\Models\Banca\TraspasoBanca as Traspaso;
use App\Services\clsFileReader;

class TraspasoBancaImport
{
    public $nombreOriginal;
    public $config;

    public function __construct($nombreArchivo, $config)
    {
        $this->nombreOriginal = $nombreArchivo;
        $this->config = $config;
    }

    public function import($file)
    {
        // Leer y procesar el archivo
        $rows = $this->parseFile($file);
dd($rows);
        foreach ($rows as $row) {
            try {
                // Crear un modelo y asignar valores
                $model = new Traspaso();
                $model->Date = $this->sanitizeDate($row['Date'] ?? null);
                $model->Libelle = $this->sanitize($row['Libelle'] ?? null);
                $model->MontantEUROS = $this->sanitize($row['MontantEUROS'] ?? null);
                $model->MontantFRANCS = $row['MontantFRANCS'] ?? 0;
                $model->NomArchTras = $this->nombreOriginal;
                $model->save();
            } catch (\Illuminate\Database\QueryException $e) {
                if ($e->getCode() === '23000') {
                    // Registro duplicado, saltar
                    continue;
                } else {
                    throw $e; // Otros errores
                }
            }
        }
    }

    /**
     * Leer el archivo usando clsFileReader
     */
    private function parseFile($file)
    {
        $reader = new clsFileReader($file->getRealPath(), $this->config['separadorCampos'], $this->config['caracterString']);
        $rows = $reader->readAll();

        return $rows ?: []; // Retorna las filas o un array vacío
    }

    /**
     * Limpia un valor eliminando caracteres no válidos
     */
    private function sanitize($value)
    {
        return $value ? preg_replace('/[^\x20-\x7E]/', '', $value) : null;
    }

    /**
     * Convierte un string de fecha al formato YYYY-MM-DD
     */
    private function sanitizeDate($value)
    {
        if (!$value) {
            return null;
        }

        try {
            return \Carbon\Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
        } catch (\Exception $e) {
            return null; // Fecha inválida
        }
    }
}
