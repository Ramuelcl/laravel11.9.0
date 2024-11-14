<?php
// app\Models\backend\Tabla.php

namespace App\Models\backend;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Schema;

class Tabla extends Model
{
  use HasFactory, SoftDeletes;

  protected $table = 'tablas';

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
    'tabla' => 'integer',
    'tabla_id' => 'integer',
    'is_active' => 'boolean',
    'valores' => 'array', // Cast 'json' column as an array
  ];

  public function qTablas($table, $excluirUltimo = true, $campos = ['tabla_id', 'valores']) // nunca excluye el ultimo campo=99
  {
    // Obtén los registros filtrados por los campos solicitados
    $registros = Tabla::where('tabla', $table)
      ->where('is_active', true)
      ->select($campos)
      ->get()->toArray();
    // Inicializa el arreglo de resultados
    // dd($registros);
    $resultados = [];
    if ($excluirUltimo)
      $paso =  array_pop($registros);
    // dd($registros);
    // Verifica si se encontraron registros)
    if (!empty($registros)) {
      // Procesa cada registro
      $item = [];
      foreach ($registros as $registro) {
        $tabla_id = null;
        // Itera sobre $registro ya que es siempre un array
        foreach ($registro as $ind => $valor) {
          // dump($ind, $valor);
          if ($ind == 'valores') {
            foreach ($valor as $key => $value) {
              $item[$tabla_id] = $value;
            }
          } else {
            // 'tabla_id' debe mantener su indice original
            $tabla_id = $valor;
          }
        }

        // Agrega el registro procesado al arreglo de resultados
      }
      $resultados = $item;
    }

    // Retorna el arreglo con el formato solicitado
    return $resultados;
  }

  public function getMenuWithSubMenus($table)
  {
    $menuData = $this->getMenuData($table);

    // Create a lookup table for faster access by parent_id
    $menuItemsByParentId = [];
    foreach ($menuData as &$item) {
      $menuItemsByParentId[$item['id']] = &$item;
    }

    // Build the nested menu structure
    $rootMenus = [];
    foreach ($menuData as &$item) {
      $parentId = $item['parent_id'] ?? 0; // Default to 0 if no parent

      if ($parentId == 0) {
        $rootMenus[] = &$item;
      } else {
        if (isset($menuItemsByParentId[$parentId])) {
          $menuItemsByParentId[$parentId]['submenu'][] = &$item;
        }
      }
    }
    return $rootMenus;
  }

  public function getMenuData($table)
  {
    // Obtener los datos de la tabla y formar el arreglo
    $arreglo = Tabla::where('tabla', $table)
      ->where('is_active', true)
      ->select('tabla_id as id', 'valores')
      ->get()
      ->map(function ($item) {
        $data = $item->valores;
        $data['id'] = $item->id; // Agregar el 'id' al array $data
        return $data;
      })
      ->toArray();

    // Función recursiva para encontrar hijos y asignarlos al padre correspondiente
    function buildMenu(&$items, $parentId = 0)
    {
      // dd($items, $parentId);
      $menu = [];
      foreach ($items as $key => &$item) {
        if ($item['parent_id'] === $parentId) {
          // Remover el hijo del arreglo principal
          unset($items[$key]);

          // Recursivamente obtener los hijos de este elemento
          $item['submenu'] = buildMenu($items, $item['id']);

          // Agregar el elemento al menú del padre actual
          $menu[] = $item;
        }
      }
      // dump($items, $menu);
      return $menu;
    }

    // Construir el menú a partir de los elementos sin padres (parent_id = null)
    $menu = buildMenu($arreglo);

    // Mostrar el menú final
    // dd($menu);
    return $menu;
  }

  public function getSubMenuData($table)
  {
    $menuData = $this->getMenuData($table);

    $subMenus = [];
    foreach ($menuData as $item) {
      if (isset($item['submenu']) && !empty($item['submenu'])) {
        $subMenus[$item['id']] = $item['submenu'];
      }
    }
    return $subMenus;
  }

  // Accesor para el campo 'json'
  public function getValoresAttribute($value)
  {
    return json_decode($value, true);
  }

  // Mutador para el campo 'valores'
  public function setValoresAttribute($value)
  {
    $this->attributes['valores'] = json_encode($value);
  }

  public function scopeTabla($query, $tabla)
  {
    return $query->where('tabla', $tabla)
      ->where('is_active', true);
  }

  public function scopeTabla_Id($query, $tabla, $id)
  {
    return $query->where('tabla', $tabla)
      ->where('tabla_id', $id)
      ->where('is_active', true);
  }
}
