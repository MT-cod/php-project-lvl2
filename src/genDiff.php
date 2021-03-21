<?php

namespace Projects\lvl2;

//Основные функции>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
function genDiff(\Docopt\Response $args): string
{
    $arr1 = getAssocArrayFromFile($args['<firstFile>']);
    $arr2 = getAssocArrayFromFile($args['<secondFile>']);

    $resultArray = genDiffFromArrays($arr1, $arr2);

    return resultArrayToResultString($resultArray);
}

//Возвращаем результирующий массив отличий 2-ух массивов
function genDiffFromArrays(array $arr1, array $arr2): array
{
    $mergedAndSortedArrs = mergeAndSortArrs($arr1, $arr2);
    $res = [];
    foreach ($mergedAndSortedArrs as $key => $item) {
        if (!key_exists($key, $arr1) && key_exists($key, $arr2)) {
            $res["+ $key"] = ifItemIsArrThenMapKeys($item);
        } elseif (key_exists($key, $arr1) && !key_exists($key, $arr2)) {
            $res["- $key"] = ifItemIsArrThenMapKeys($item);
        } else {
            if ($arr1[$key] === $arr2[$key]) {
                $res["  $key"] = ifItemIsArrThenMapKeys($item);
            } else {
                if (!is_array($item)) {
                    $res["- $key"] = ifItemIsArrThenMapKeys($arr1[$key]);
                    $res["+ $key"] = ifItemIsArrThenMapKeys($arr2[$key]);
                } else {
                    //Если значение по ключу вложенный массив, присутствующий в обоих переданных файлах,
                    //то проходимся по этому массиву этой же функцией для поиска различий
                    $res["  $key"] = genDiffFromArrays($arr1[$key], $arr2[$key]);
                }
            }
        }
    }
    return $res;
}

function mergeAndSortArrs(array $arr1, array $arr2): array
{
    $merged = array_merge($arr1, $arr2);
    ksort($merged);
    return $merged;
}

//Проверяем, если значение массив, то возвращаем его с помеченными пробелами ключами
//(Для значений по которым уже не будут вычисляться различия)
function ifItemIsArrThenMapKeys(mixed $item, array $res = []): mixed
{
    if (is_array($item)) {
        foreach ($item as $key => $val) {
            if (!is_array($val)) {
                $res["  $key"] = $val;
            } else {
                //Если значение по ключу вложенный массив, то проходимся по этому массиву
                //этой же функцией для пометки
                $res["  $key"] = ifItemIsArrThenMapKeys($val);
            }
        }
        return $res;
    } else {
        return $item;
    }
}

//Возвращаем результат в строчном виде
function resultArrayToResultString(array $resultArray): string
{
    $res = json_encode($resultArray, JSON_PRETTY_PRINT);
    $res = preg_filter("/  \"|\"|\,/", '', $res);
/*    foreach ($resultArray as $key => $value) {
        if (!is_array($value)) {
            $res .=  "$spacing$key: " . ifBoolOr0ToString($value) . "\n";
        } else {
            //Если значение по ключу вложенный массив, то проходимся по этому массиву
            //этой же функцией для приведения к строчному виду
            $res .= "$spacing$key: {\n" . resultArrayToResultString($value, $spacing = $spacing . "  ");
            $res .= "$spacing}\n";
            $spacing = substr_replace($spacing, "  ", 0);
        }
    }*/
    return $res;
}

//Проверяем, если значение булево или ноль, то возвращаем его эквивалент в строке
/*function ifBoolOr0ToString(mixed $value): mixed
{
    if ($value === true) {
        return 'true';
    } elseif ($value === false) {
        return 'false';
    } elseif ($value === null) {
        return 'null';
    } else {
        return $value;
    }
}*/
