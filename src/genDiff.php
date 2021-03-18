<?php

namespace Projects\lvl2;

//Основные функции>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
function genDiff(\Docopt\Response $args): string
{
    $arr1 = getAssocArrayFromFiles($args['<firstFile>']);
    $arr2 = getAssocArrayFromFiles($args['<secondFile>']);
    return genDiffFromArrays($arr1, $arr2);
}

//Возвращаем ассоциативный массив из переданного json-а
function getAssocArrayFromFiles(string $file): array
{
    return json_decode(file_get_contents($file), true);
}

//Возвращаем строку отличий 2-ух массивов
function genDiffFromArrays(array $arr1, array $arr2): string
{
    $merged = array_merge($arr1, $arr2);
    ksort($merged);
    $res = "{\n";
    foreach ($merged as $key => $item) {
        if (!key_exists($key, $arr1) && key_exists($key, $arr2)) {
            $res .=  "+ $key: " . ifBoolToString($item) . "\n";
        } elseif (key_exists($key, $arr1) && !key_exists($key, $arr2)) {
            $res .=  "- $key: " . ifBoolToString($item) . "\n";
        } else {
            if ($arr1[$key] === $arr2[$key]) {
                $res .=  "  $key: " . ifBoolToString($item) . "\n";
            } else {
                $res .=  "- $key: " . ifBoolToString($arr1[$key]) . "\n";
                $res .=  "+ $key: " . ifBoolToString($arr2[$key]) . "\n";
            }
        }
    }
    $res .= "}\n";
    return $res;
}

//Проверяем, если значение булево, то возвращаем его эквивалент в строке
function ifBoolToString(mixed $value): mixed
{
    if ($value === true) {
        return 'true';
    } elseif ($value === false) {
        return 'false';
    } else {
        return $value;
    }
}
