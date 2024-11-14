<?php

namespace App\Models\post;

use App\Models\backend\Categoria;
use App\Models\backend\Marca;
// use App\Models\post\Post;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // Import the Str class

class Post extends Model
{
    use HasFactory;

    protected $fillable = ["titulo", "contenido", "estado", "is_active", "image_path", "categoria_id", "marcas"];
    protected $hidden = ["slug"];

    // Accessor for the slug attribute
    public function getSlugAttribute()
    {
        return Str::slug($this->nombre); // Generate the slug
    }

    // relacion uno a muchos polimorfica
    public function categoria()
    {
        return $this->hasOne(Categoria::class, "categoria_id");
        // return $this->morphOne(Categoria::class, 'categorizable');
    }

    // relacion muchos a muchos
    // public function marcas()
    // {
    //     return $this->morphMany(Marca::class);
    // }
}
