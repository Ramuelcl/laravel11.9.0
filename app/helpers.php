<?php
// app/helpers.php
// Modifica tu archivo composer.json para agregar la carga del archivo con la clave files dentro de la sección autoload de la siguiente manera:
// ],
// "files": [
//     "app/helpers.php"
// ],
// ---
// ejecutar: composer dump-autoload
//

if (!function_exists("fncGlob_Files")) {
    // TODO: recursividad en directorios
    function fncGlob_Files($folder, $name = "*", $ext = "jpg,jpeg,png", $limit = 0, $sec = 0, $recur = false)
    {
        dump([$folder, $name, $ext, $folder . $name . "." . $ext]);
        if (!is_dir($folder)) {
            die("Invalid directory.\n\n");
        }

        // $FILES = glob($folder.$name."."."{$ext}", GLOB_BRACE);
        $FILES = glob($folder . $name . "." . $ext);
        // dump($FILES);
        $set_limit = 0;

        foreach ($FILES as $key => $file) {
            if ($set_limit && $set_limit == $limit) {
                break;
            }

            if (filemtime($file) > $sec) {
                $FILE_LIST[$key]["path"] = substr($file, 0, strrpos($file, "\\") + 1);
                $array = explode(".", substr($file, strrpos($file, "\\") + 1));
                $FILE_LIST[$key]["name"] = $array[0];
                $FILE_LIST[$key]["ext"] = $array[1];
                $FILE_LIST[$key]["filename"] = $file;

                // $FILE_LIST[$key]['name']    = substr( $file, ( strrpos( $file, "\\" ) +1 ) );
                $FILE_LIST[$key]["size"] = filesize($file);
                $FILE_LIST[$key]["date"] = date("Y-m-d G:i:s", filemtime($file));

                if ($set_limit > 0) {
                    $set_limit++;
                }
            }
        }
        if (!empty($FILE_LIST)) {
            return $FILE_LIST;
        } else {
            die("No files found!\n\n");
        }
    }

    // So....

    // $folder = "c:\temp";
    // $name   = "my_videos";
    // $ext    = "flv,mp4"; // flash video files
    // $limit  = 2; // 0 = sin límite
    // $sec    = "7200"; // files older than 2 hours, 0 = sin límite

    // print_r(glob_files($folder, $name, $ext, $limit, $sec));

    // Would return:

    // Array
    // (
    //     [0] => Array
    //         (
    //             [path] => c:\temp\my_videos\
    //             [name] => fluffy_bunnies.flv
    //             [size] => 21160480
    //             [date] => 2007-10-30 16:48:05
    //         )

    //     [1] => Array
    //         (
    //             [path] => c:\temp\my_videos\
    //             [name] => synergymx.com.flv
    //             [size] => 14522744
    //             [date] => 2007-10-25 15:34:45
    //         )
    // )
}

if (!function_exists("current_user")) {
    function current_user()
    {
        return auth()->user();
    }
}

if (!function_exists("images")) {
    function images($path = "")
    {
        return asset("/storage/images/$path");
    }
}

if (!function_exists("fncStoragePath")) {
    function fncStoragePath($image_name)
    {
        return "/storage/images/" . $image_name;
    }
}

if (!function_exists("fncIconPath")) {
    function fncIconPath($nombre, $tipo)
    {
        if ($tipo == "solid") {
            $path = config("guzanet.icon_paths.solid");
        } else {
            $path = config("guzanet.icon_paths.outline");
        }

        $iconFilePath = public_path("$path/$nombre.blade.php"); // Use public_path()

        // Check if the file exists
        if (file_exists($iconFilePath)) {
            return $iconFilePath; // Return the asset path
        } else {
            return "archivo no existe";
        }
    }
}

// Regex quick reference
// [abc]     A single character: a, b or c
// [^abc]     Any single character but a, b, or c
// [a-z]     Any single character in the range a-z
// [a-zA-Z]     Any single character in the range a-z or A-Z
// ^     Start of line
// $     End of line
// \A     Start of string
// \z     End of string
// .     Any single character
// \s     Any whitespace character
// \S     Any non-whitespace character
// \d     Any digit
// \D     Any non-digit
// \w     Any word character (letter, number, underscore)
// \W     Any non-word character
// \b     Any word boundary character
// (...)     Capture everything enclosed
// (a|b)     a or b
// a?     Zero or one of a
// a*     Zero or more of a
// a+     One or more of a
// a{3}     Exactly 3 of a
// a{3,}     3 or more of a
// a{3,6}     Between 3 and 6 of a

// options: i case insensitive m make dot match newlines x ignore whitespace in regex o perform #{...} substitutions only once
if (!function_exists("fncRegex")) {
    function fncRegex(string $str, $pattern = "Any digit:?", $oneNotAll = true)
    {
        $p = explode(":", $pattern);
        $pattern = $p[0];
        $value = null;
        if (sizeof($p) > 1) {
            $value = $p[1];
        }
        // dd($p, $pattern, $value);
        switch ($pattern) {
            case "Any digit":
                $pattern = "/d+/";
                break;
            case "single character lowercase":
                $pattern = "/[a-z]/";
                break;
            case "single character uppercase":
                $pattern = "/[a-zA-Z]/";
                break;
        }

        $matches = null;
        if ($oneNotAll) {
            if (preg_match($pattern, $str, $matches)) {
                print_r($matches);
            }
        } else {
            if (preg_match_all($pattern, $str, $matches)) {
                print_r($matches);
            }
        }

        return $matches;
    }
}

if (!function_exists("setActive")) {
    function setActive($route = "home")
    {
        return request()->routeIs($route) ? "active" : "";
    }
}

if (!function_exists("fncChangeNumberFormate")) {
    function fncChangeNumberFormate($strNum, $float = false)
    {
        // PRIMERA OPCION
        if (strpos($strNum, ",") > 0) {
            $explode = explode(",", $strNum);
            $float = true;
        } elseif (strpos($strNum, ".") > 0) {
            $explode = explode(".", $strNum);
            $float = true;
        } else {
            $implode[] = $strNum;
        }

        if ($float) {
            $implode = implode(".", $explode);
            $num = floatval($implode);
        } else {
            $num = intval($implode);
        }

        // SEGUNDA OPCION
        // if (sizeof($explode) > 1) {
        //     // viene con decimales
        //     if ($float)
        //         $num = (float)((int)$explode[0] . '.' . (int)$explode[1]);
        //     else
        //         $num = (int)$explode[0];
        // } else {
        //     if ($float)
        //         $num = (float)((int)$explode . '.0');
        //     else
        //         $num = (int)$explode;
        // }
        return $num;
    }
}

if (!function_exists("fncChangeDateFormate")) {
    function fncChangeDateFormate($strFecha, $formato = "Ymd")
    {
        $dtz = "America/Santiago";
        $DateTimeZone = "Europe/Paris"; //print_r(DateTimeZone::listIdentifiers());
        // $date = \Carbon\Carbon::parse($strFecha, $dtz);
        $explode = explode("/", $strFecha);

        $implode = implode("/", [$explode[1], $explode[0], $explode[2]]);
        $date = \Carbon\Carbon::parse($implode, $DateTimeZone);
        // $strtotime = strtotime($implode);

        // dump([$strFecha => $date],);
        // dump([$strFecha => $date], ['explode' => $explode], ['implode' => $implode], ['strtotime' => $strtotime], ['DateTimeZone' => $DateTimeZone],);
        // sleep(8);
        return $date;
        // return $date->format($formato);
    }
}

/**
 * helpers de nombres y correos
 *
 * @param [string] $nombre
 * @return string (iniciales el nombre)
 */

if (!function_exists("getIniciales")) {
    function getIniciales($nombre)
    {
        $name = "";
        $explode = explode(" ", $nombre);
        foreach ($explode as $x) {
            $name .= $x[0];
        }
        return $name;
    }
}

if (!function_exists("fncNormalizeString")) {
    function fncNormalizeString($string)
    {
        $string = strtolower($string);
        $unwantedArray = [
            "á" => "a",
            "é" => "e",
            "í" => "i",
            "ó" => "o",
            "ú" => "u",
            "à" => "a",
            "è" => "e",
            "ì" => "i",
            "ò" => "o",
            "ù" => "u",
            "ä" => "a",
            "ë" => "e",
            "ï" => "i",
            "ö" => "o",
            "ü" => "u",
            "â" => "a",
            "ê" => "e",
            "î" => "i",
            "ô" => "o",
            "û" => "u",
            "ã" => "a",
            "ñ" => "n",
            "õ" => "o",
            "ç" => "c",
            "Á" => "a",
            "É" => "e",
            "Í" => "i",
            "Ó" => "o",
            "Ú" => "u",
            "À" => "a",
            "È" => "e",
            "Ì" => "i",
            "Ò" => "o",
            "Ù" => "u",
            "Ä" => "a",
            "Ë" => "e",
            "Ï" => "i",
            "Ö" => "o",
            "Ü" => "u",
            "Â" => "a",
            "Ê" => "e",
            "Î" => "i",
            "Ô" => "o",
            "Û" => "u",
            "Ã" => "a",
            "Ñ" => "n",
            "Õ" => "o",
            "Ç" => "c",
        ];
        return strtr($string, $unwantedArray);
    }
}

if (!function_exists("fncHexa_Rgb")) {
    function fncHexa_Rgb($hexa)
    {
        [$r, $g, $b] = \sscanf($hexa, "#%02x%02x%02x");
        return "rgb($r,$g,$b)";
    }
}

/**
 * Funcion para eliminar los valores duplicados consecutivos en cada palabra
 * de una frase
 *
 * @param string $str
 *
 * @return string
 */
if (!function_exists("fncElimCaracterDuplicado")) {
    function fncElimCaracterDuplicado($str)
    {
        return implode(
            " ",
            array_map(function ($palabra) {
                preg_match_all("/./u", $palabra, $matches);
                return array_reduce($matches[0], function ($acum, $letra) {
                    return $acum == null || ($acum[-1] != $letra && substr($acum, -2) != $letra) ? $acum . $letra : $acum;
                });
            }, explode(" ", preg_replace("/\s+/", " ", $str))),
        );
    }
}

/**
 * Funcion para buscar archivo(s) en un directorio o subdirectorios
 *
 * @param string $path  directorio padre
 * @param array $files  nombre(s) de archivo(s) default=*
 * @param array $ext    nombre(s) de extension(es) default=*
 * @param array $exc    excluir del resultado default='dir', 'file'
 *
 * @return array | false
 */
if (!function_exists("fncBuscaArchivos")) {
    function fncBuscaArchivos($path, $files = ["*"], $ext = ["*"], $exc = ["dir", "file"])
    {
        static $mapa;

        if (is_dir($path)) {
            #Obtener un arreglo con directorios y archivos
            $subdirectorios_o_archivos = scandir($path);
            foreach ($subdirectorios_o_archivos as $subdirectorio_o_archivo) {
                # Omitir . y .., pues son directorios
                # que se refieren al directorio actual
                # o al directorio padre
                if ($subdirectorio_o_archivo != "." && $subdirectorio_o_archivo != "..") {
                    # Si es un directorio, recursión
                    if (is_dir($path . "/" . $subdirectorio_o_archivo)) {
                        fncBuscaArchivos($path . "/" . $subdirectorio_o_archivo, $files, $ext, $exc);
                    } else {
                        # Si es un archivo, lo eliminamos con unlink
                        $mapa["$path"] = $subdirectorio_o_archivo;
                    }
                }
            }
        }
        return $mapa;
    }
}
