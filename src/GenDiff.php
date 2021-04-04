<?php

namespace Differ\Differ;

use function Funct\Collection\sortBy;

//Головная функция дифа
function genDiff(string $pathToFile1, string $pathToFile2, string $outFormat = 'stylish'): array | bool | string | null
{
    $arr1 = getAssocArrayFromFile($pathToFile1);
    $arr2 = getAssocArrayFromFile($pathToFile2);
    $resultDiffArr = genDiffFromArrays($arr1, $arr2);
    return resultArrayToResultString($resultDiffArr, $outFormat);
}

//Генерируем результирующий массив отличий 2-ух массивов
function genDiffFromArrays(array $arr1, array $arr2, array $diffResult = []): array
{
    $mergedAndSortedArrays = mergeAndSortArrays($arr1, $arr2);
    $diffResult = array_map(function ($nodeData) use ($arr1, $arr2) {
        if (!key_exists($nodeData['nodeKey'], $arr1) && key_exists($nodeData['nodeKey'], $arr2)) {
            return ['nodeKey' => $nodeData['nodeKey'], 'nodeValue' => $nodeData['child'], 'diffStatus' => 'added'];
        } elseif (key_exists($nodeData['nodeKey'], $arr1) && !key_exists($nodeData['nodeKey'], $arr2)) {
            return ['nodeKey' => $nodeData['nodeKey'], 'nodeValue' => $nodeData['child'], 'diffStatus' => 'deleted'];
        } else {
            if ($arr1[$nodeData['nodeKey']] === $arr2[$nodeData['nodeKey']]) {
                return [
                    'nodeKey' => $nodeData['nodeKey'],
                    'nodeValue' => $nodeData['child'],
                    'diffStatus' => 'unchanged'
                ];
            } else {
                if (is_array($arr1[$nodeData['nodeKey']]) && is_array($arr2[$nodeData['nodeKey']])) {
                    $childsRecurs = genDiffFromArrays($arr1[$nodeData['nodeKey']], $arr2[$nodeData['nodeKey']]);
                    return ['nodeKey' => $nodeData['nodeKey'], 'child' => $childsRecurs];
                } else {
                    return [
                        'nodeKey' => $nodeData['nodeKey'],
                        'nodeValueOld' => $arr1[$nodeData['nodeKey']],
                        'nodeValueNew' => $arr2[$nodeData['nodeKey']],
                        'diffStatus' => 'updated'
                    ];
                }
            }
        }
    }, $mergedAndSortedArrays);
    return $diffResult;
}

//Складываем массивы в один, сортируем и подготавливаем начальную структуру для дальнейшего поиска отличий
function mergeAndSortArrays(array $arr1, array $arr2): array
{
    $merged = $arr2 + $arr1;
    $sorted = sortBy($merged, fn($row) => $row, 'ksort');
    $reduced = array_map(
        fn($nodeKey, $child) => ['nodeKey' => $nodeKey, 'child' => $child],
        array_keys($sorted),
        array_values($sorted)
    );
    return $reduced;
}
