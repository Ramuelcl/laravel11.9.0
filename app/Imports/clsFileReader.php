<?php

namespace App\Services;

class clsFileReader
{
    private $filePath;
    private $delimiter;
    private $enclosure;

    public function __construct($filePath, $delimiter = ',', $enclosure = '"')
    {
        $this->filePath = $filePath;
        $this->delimiter = $delimiter;
        $this->enclosure = $enclosure;
    }

    /**
     * Leer todas las filas del archivo como un array asociativo
     */
    public function readAll()
    {
        if (!file_exists($this->filePath)) {
            throw new \Exception("Archivo no encontrado: " . $this->filePath);
        }

        $rows = [];
        if (($handle = fopen($this->filePath, 'r')) !== false) {
            $headers = fgetcsv($handle, 0, $this->delimiter, $this->enclosure); // Obtener encabezados

            while (($data = fgetcsv($handle, 0, $this->delimiter, $this->enclosure)) !== false) {
                $rows[] = array_combine($headers, $data); // Combina encabezados con valores
            }

            fclose($handle);
        }

        return $rows;
    }
}
