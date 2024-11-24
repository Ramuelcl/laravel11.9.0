<?php

namespace App\Models\banca;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Traspaso extends Model
{
    use HasFactory;

    protected $table = 'traspasosBanca';
    protected $fillable = ['Date', 'Libelle', 'MontantEUROS', 'MontantFRANCS', 'NomArchTras', 'idArchMov'];
}
