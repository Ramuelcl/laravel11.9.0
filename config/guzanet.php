<?php

// config/guzanet.php
return [
  "sistema" => [
    ["banca" => 1],
    ["trabajo" => 2],
    ["ventas" => 3],
    ["compras" => 4],
    ["inventario" => 5],
    ["remuneraciones" => 7],
  ],
  "clave" => "valor",
  "appEmpresa" => "Guzanet",
  "appLogo" => "app/logo/Guzanet.png", //public\app\logo

  "appNombre" => "Ramuel Gonzalez",
  "appMail" => "Ramuelcl@gmail.com",
  "appLargoClave" => 3,

  "idioma" => "es-ES",
  "idiomasDir" => "app/flags/",
  "idiomas" => ["es" => "Español", "en" => "English", "fr" => "Français"],
  "icon_paths" => [
    "solid" => "app/icons/solid", //public\app\icons
    "outline" => "app/icons/outline", //public\app\icons
  ],
  "appThemes" => [
    "colores" => ["azul", "verde", "amarillo", "rojo"],
    "fondo" => "images/app/fondo.png",
  ],
  "appTheme" => "theme01",
];

/**
 *
// Acceder a un valor específico
$valor = config('nombre-del-archivo.clave');

// Acceder a todos los valores como un array asociativo
$configuracion = config('nombre-del-archivo');

// Obtener el valor actual de la configuración
$valorActual = config('nombre-del-archivo.clave');

// Modificar el valor en tiempo de ejecución
config(['nombre-del-archivo.clave' => 'nuevo_valor']);

 */
