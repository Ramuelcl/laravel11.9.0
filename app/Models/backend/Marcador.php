<?php

namespace App\Models\backend;

use App\Models\imagen\Imagen;
use App\Models\post\Post;
use App\Models\video\Video;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Marcador extends Model
{
  use HasFactory, SoftDeletes;

  protected $table = 'marcadores';

  /**
   * The attributes that aren't mass assignable.
   *
   * @var array
   */
  protected $guarded = [];

  protected $fillable = ["nombre"];
  protected $hidden = ["slug"];

  // Accessor for the slug attribute
  public function getSlugAttribute()
  {
    return Str::slug($this->nombre); // Generate the slug
  }
  protected $casts = [
    'id' => 'integer',
    'metadata' => 'array',
    'is_active' => 'boolean',
  ];

  public function xPosts(): MorphToMany
  {
    return $this->morphedByMany(Post::class, 'marcadorable');
  }

  // public function xVideos(): MorphToMany
  // {
  //   return $this->morphedByMany(Video::class, 'marcadorable');
  // }

  // public function xImagens(): MorphToMany
  // {
  //   return $this->morphedByMany(Imagen::class, 'marcadorable');
  // }

  // public function xMovimientos(): MorphToMany
  // {
  //   return $this->morphedByMany(\App\Models\banca\Movimiento::class, 'marcadorable');
  // }
}
