<?php

namespace Projects\lvl2;

//Основные функции>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
function genDiff(\Docopt\Response $args): string
{
    $arr1 = getAssocArrayFromFile($args['<firstFile>']);
    $arr2 = getAssocArrayFromFile($args['<secondFile>']);


    $mergedAndSortedArrs = array_merge($arr1, $arr2);
    ksort($mergedAndSortedArrs);

    $resultArray = genDiffFromArrays($mergedAndSortedArrs, $arr1, $arr2);
    return resultArrayToResultString($resultArray);
}

//Возвращаем результирующий массив отличий 2-ух массивов
function genDiffFromArrays(array $mergedAndSortedArrs, array $arr1, array $arr2): array
{
    $res = [];
    foreach ($mergedAndSortedArrs as $key => $item) {
        if (!key_exists($key, $arr1) && key_exists($key, $arr2)) {
            $res["+ $key"] =  $item;
        } elseif (key_exists($key, $arr1) && !key_exists($key, $arr2)) {
            $res["- $key"] =  $item;
        } else {
            if ($arr1[$key] === $arr2[$key]) {
                $res["  $key"] =  $item;
            } else {
                $res["- $key"] =  $arr1[$key];
                $res["+ $key"] =  $arr2[$key];
            }
        }
    }
    return $res;
}

//Возвращаем результат в строчном виде
function resultArrayToResultString(array $resultArray): string
{
    $res = "{\n";
    foreach ($resultArray as $key => $value) {
        $res .=  "$key: " . ifBoolToString($value) . "\n";
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
