<?php

namespace App\Models\backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use App\Models\backend\Categorizable;
use App\Models\post\Post;
use Illuminate\Support\Str; // Import the Str class

class Categoria extends Model
{
    use HasFactory;

    protected $fillable = ["nombre"];
    protected $hidden = ["slug"];

    public function posts()
    {
        return $this->belongsTo(Post::class);
        // return $this->morphedByMany(Post::class, 'categorizable');
    }

    // Accessor for the slug attribute
    public function getSlugAttribute()
    {
        return Str::slug($this->nombre); // Generate the slug
    }
}
