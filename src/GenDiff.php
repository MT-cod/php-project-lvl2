<?php

namespace Differ\Differ;

//Головная функция дифа
function genDiff(string $pathToFile1, string $pathToFile2, string $outputFormat = 'stylish'): string
{
    $arr1 = getAssocArrayFromFile($pathToFile1);
    $arr2 = getAssocArrayFromFile($pathToFile2);

    $resultDiffArr = genDiffFromArrays($arr1, $arr2);
    echo(json_encode($resultDiffArr, JSON_PRETTY_PRINT));
    //print_r($resultDiffArr);
    return resultArrayToResultString($resultDiffArr, $outputFormat);
}

//Генерируем результирующий массив отличий 2-ух массивов
function genDiffFromArrays(array $arr1, array $arr2): array
{
    $mergedAndSortedArrays = mergeAndSortArrs($arr1, $arr2);
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

//Складываем массивы в один, подготавливаем начальную структуру и сортируем для дальнейшего поиска отличий
function mergeAndSortArrs(array $arr1, array $arr2): array
{
    $merged = $arr2 + $arr1;
    $reduced = array_map(
        fn($nodeKey, $child) => ['nodeKey' => $nodeKey, 'child' => $child],
        array_keys($merged),
        array_values($merged)
    );
    sort($reduced);
    return $reduced;
}
