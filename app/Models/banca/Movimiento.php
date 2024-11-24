<?php
// app\Models\banca\Movimientos.php

namespace App\Models\banca;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Movimiento extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'movimientosBanca';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'dateMouvement' => 'date',
        'montant' => 'decimal:2',
        'francs' => 'decimal:2',
        'cliente_id' => 'integer',
        'releve' => 'integer',
        'dateReleve' => 'date',
        'estado' => 'integer',
        'conciliada' => 'integer',
    ];
}
