<?php

namespace Differ\Differ;

//Головная функция дифа
function genDiff(string $pathToFile1, string $pathToFile2, string $outputFormat = 'stylish'): string
{
    $arr1 = getAssocArrayFromFile($pathToFile1);
    $arr2 = getAssocArrayFromFile($pathToFile2);

    $resultArray = genDiffFromArrays($arr1, $arr2);

    return resultArrayToResultString($resultArray, $outputFormat);
}

//Возвращаем результирующий массив отличий 2-ух массивов
function genDiffFromArrays(array $arr1, array $arr2, array $diffResult = []): array
{
    $mergedAndSortedArrays = mergeAndSortArrs($arr1, $arr2);
    array_walk($mergedAndSortedArrays, function ($item, $key) use (&$diffResult, $arr1, $arr2) {
        if (!key_exists($key, $arr1) && key_exists($key, $arr2)) {
            $diffResult[$key] = ['diffStatus' => 'added', 'value' => $item];
        } elseif (key_exists($key, $arr1) && !key_exists($key, $arr2)) {
            $diffResult[$key] = ['diffStatus' => 'deleted', 'value' => $item];
        } else {
            if ($arr1[$key] === $arr2[$key]) {
                $diffResult[$key] = ['diffStatus' => 'unchanged', 'value' => $item];
            } else {
                if (is_array($arr1[$key]) && is_array($arr2[$key])) {
                    $diffResult[$key] = genDiffFromArrays($arr1[$key], $arr2[$key]);
                } else {
                    $diffResult[$key] = [
                        'diffStatus' => 'updated', 'oldValue' => $arr1[$key], 'newValue' => $arr2[$key]
                    ];
                }
            }
        }
    });
    ksort($diffResult);
    return $diffResult;
}

//Мёржим массивы в один и сортируем после мёржа для дальнейшего поиска отличий
function mergeAndSortArrs(array $arr1, array $arr2): array
{
    $merged = array_merge($arr1, $arr2);
    ksort($merged);
    return $merged;
}
