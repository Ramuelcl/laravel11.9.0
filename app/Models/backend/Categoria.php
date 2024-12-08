<?php

namespace App\Models\backend;

use App\Models\backend\Entidad;
// use App\Models\backend\Categorizable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // Import the Str class

class Categoria extends Model
{
    use HasFactory;

    protected $fillable = ["nombre"];
    protected $hidden = ["slug"];

    public function entidades()
    {
        return $this->hasMany(Entidad::class);
        // return $this->morphedByMany(Entidad::class, 'categoriable');
    }

    // Accessor for the slug attribute
    public function getSlugAttribute()
    {
        return Str::slug($this->nombre); // Generate the slug
    }
}
