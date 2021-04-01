<?php

namespace Differ\Differ;

//Головная функция дифа
function genDiff(string $pathToFile1, string $pathToFile2, string $outputFormat = 'stylish'): string
{
    $arr1 = getAssocArrayFromFile($pathToFile1);
    $arr2 = getAssocArrayFromFile($pathToFile2);

    $resultDiffArr = genDiffFromArrays($arr1, $arr2);
    echo(json_encode($resultDiffArr, JSON_PRETTY_PRINT));
    return resultArrayToResultString($resultDiffArr, $outputFormat);
}

//Возвращаем результирующий массив отличий 2-ух массивов
function genDiffFromArrays(array $arr1, array $arr2): array
{
    $mergedAndSortedArrays = mergeAndSortArrs($arr1, $arr2);
    $diffResult = array_map(function ($nodeKey, $nodeValue) use ($arr1, $arr2) {
        if (!key_exists($nodeKey, $arr1) && key_exists($nodeKey, $arr2)) {
            return [$nodeKey => ['diffStatus' => 'added', 'value' => $nodeValue]];
        } elseif (key_exists($nodeKey, $arr1) && !key_exists($nodeKey, $arr2)) {
            return [$nodeKey => ['diffStatus' => 'deleted', 'value' => $nodeValue]];
        } else {
            if ($arr1[$nodeKey] === $arr2[$nodeKey]) {
                return [$nodeKey => ['diffStatus' => 'unchanged', 'value' => $nodeValue]];
            } else {
                if (is_array($arr1[$nodeKey]) && is_array($arr2[$nodeKey])) {
                    $nodeValueRecurs = genDiffFromArrays($arr1[$nodeKey], $arr2[$nodeKey]);
                    return [$nodeKey => $nodeValueRecurs];
                } else {
                    return [$nodeKey => [
                        'diffStatus' => 'updated', 'oldValue' => $arr1[$nodeKey], 'newValue' => $arr2[$nodeKey]
                    ]];
                }
            }
        }
    }, array_keys($mergedAndSortedArrays), array_values($mergedAndSortedArrays));
    $flattenedDiffResult = array_reduce($diffResult, fn($res, $arr) => $res + $arr, []);
    ksort($flattenedDiffResult);
    return $flattenedDiffResult;
}

//Мёржим массивы в один и сортируем после мёржа для дальнейшего поиска отличий
function mergeAndSortArrs(array $arr1, array $arr2): array
{
    $merged = array_merge($arr1, $arr2);
    ksort($merged);
    return $merged;
}
