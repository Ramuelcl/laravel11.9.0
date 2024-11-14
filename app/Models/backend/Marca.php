<?php

namespace App\Models\backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\post\Post;

use Illuminate\Support\Str; // Import the Str class

class Marca extends Model
{
    use HasFactory;

    protected $fillable = ["nombre"];
    protected $hidden = ["slug"];

    // Accessor for the slug attribute
    public function getSlugAttribute()
    {
        return Str::slug($this->nombre); // Generate the slug
    }

    // relacion muchos a muchos
    // public function posts()
    // {
    //     return $this->belongsToMany(Post::class);
    // }
}
