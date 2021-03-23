<?php

namespace Projects\lvl2;

//Головная функция дифа
function genDiff(string $outputFormat, string $pathToFile1, string $pathToFile2): string
{
    $arr1 = getAssocArrayFromFile($pathToFile1);
    $arr2 = getAssocArrayFromFile($pathToFile2);

    $resultArray = genDiffFromArrays($arr1, $arr2);
    //echo(json_encode($resultArray, JSON_PRETTY_PRINT));
    return resultArrayToResultString($resultArray, $outputFormat);
}

//Возвращаем результирующий массив отличий 2-ух массивов
function genDiffFromArrays(array $arr1, array $arr2): array
{
    $mergedAndSortedArrs = mergeAndSortArrs($arr1, $arr2);
    $diffResult = [];

    //Помечаем ключи значений "+ ", "- " или "  " для маркировки отличий в переданных массивах
    foreach ($mergedAndSortedArrs as $key => $item) {
        if (!key_exists($key, $arr1) && key_exists($key, $arr2)) {
            $diffResult["+ $key"] = ifItemIsArrThenMapKeys($item);
        } elseif (key_exists($key, $arr1) && !key_exists($key, $arr2)) {
            $diffResult["- $key"] = ifItemIsArrThenMapKeys($item);
        } else {
            if ($arr1[$key] === $arr2[$key]) {
                $diffResult["  $key"] = ifItemIsArrThenMapKeys($item);
            } else {
                if (!is_array($item)) {
                    $diffResult["- $key"] = ifItemIsArrThenMapKeys($arr1[$key]);
                    $diffResult["+ $key"] = ifItemIsArrThenMapKeys($arr2[$key]);
                } else {
                    //Если значение по ключу вложенный массив, присутствующий в обоих переданных файлах,
                    //то проходимся по этому массиву этой же функцией для поиска различий
                    $diffResult["  $key"] = genDiffFromArrays($arr1[$key], $arr2[$key]);
                }
            }
        }
    }
    return $diffResult;
}

//Мёржим массивы в один и сортируем после мёржа для дальнейшего поиска отличий
function mergeAndSortArrs(array $arr1, array $arr2): array
{
    $merged = array_merge($arr1, $arr2);
    ksort($merged);
    return $merged;
}

//Проверяем, если значение массив, то возвращаем его с помеченными пробелами "  " ключами
//(Для значений по которым уже не будут вычисляться различия)
function ifItemIsArrThenMapKeys(mixed $item, array $mapResult = []): mixed
{
    if (is_array($item)) {
        foreach ($item as $key => $val) {
            if (!is_array($val)) {
                $mapResult["  $key"] = $val;
            } else {
                //Если значение по ключу вложенный массив, то проходимся по этому массиву
                //этой же функцией для пометки
                $mapResult["  $key"] = ifItemIsArrThenMapKeys($val);
            }
        }
        return $mapResult;
    } else {
        return $item;
    }
}
