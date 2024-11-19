<?php

namespace App\Models\backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tabla extends Model
{
  use HasFactory, SoftDeletes;

  protected $table = 'tablas';
  protected static $st_menus = [];

  protected $guarded = [];

  protected $casts = [
    'tabla' => 'integer',
    'tabla_id' => 'integer',
    'is_active' => 'boolean',
    'valores' => 'array',
  ];

  /**
   * Obtiene el menú de una tabla específica.
   */
  public function getMenu($tabla)
  {
    // dump($tabla);
    if (isset(self::$st_menus[$tabla])) {
      return self::$st_menus[$tabla];
    }

    if (empty(self::$st_menus)) {
      $this->loadMenus(10000, 10999);
    }

    return self::$st_menus[$tabla] ?? [];
  }

  /**
   * Carga todos los menús entre dos rangos de tabla.
   */
  private function loadMenus($startTabla, $endTabla)
  {
    $menus = $this->whereBetween('tabla', [$startTabla, $endTabla])
      ->orderBy('tabla', 'asc')
      ->orderBy('tabla_id', 'asc')
      ->where('is_active', true)
      ->select('tabla', 'tabla_id as id', 'valores')
      ->get();

    // Organiza los menús por tabla e ID
    foreach ($menus as $menu) {
      $tabla = $menu->tabla;
      $menuData = $menu->valores;
      $menuData['id'] = $menu->id;

      if (!isset(self::$st_menus[$tabla])) {
        self::$st_menus[$tabla] = [];
      }

      // Agrega el submenú si es un hijo
      if (isset($menuData['parent_id']) && $menuData['parent_id'] > 0) {
        $parentId = $menuData['parent_id'];
        self::$st_menus[$tabla][$parentId]['submenu'][$menu->id] = $menuData;
      } else {
        // Menú principal
        self::$st_menus[$tabla][$menu->id] = $menuData;
      }
    }

    // Filtra y organiza los submenús
    foreach (self::$st_menus as $tablaKey => $menuGroup) {
      foreach ($menuGroup as $menuId => $menuData) {
        if (isset($menuData['submenu'])) {
          self::$st_menus[$tablaKey][$menuId]['submenu'] = array_values($menuData['submenu']);
        }
      }
    }
  }

  // Accesor y mutador
  public function getValoresAttribute($value)
  {
    return json_decode($value, true);
  }

  public function setValoresAttribute($value)
  {
    $this->attributes['valores'] = json_encode($value);
  }
}
