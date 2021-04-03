<?php

namespace Differ\Differ;

function stylishFormattingOfDiffResult(array $resultDiffArr): array | string | null
{
    $stylishResultArray = json_encode(stylishMapping($resultDiffArr), JSON_PRETTY_PRINT);
    if ($stylishResultArray === false) {
        return "\nStylish encode to json failed.\n";
    }
    return preg_filter("/  \"|\"|\,/", '', $stylishResultArray);
}

function stylishMapping(array $resultDiffArr): array
{
    $stylishResult = array_map(function ($node) {
        if (array_key_exists('diffStatus', $node)) {
            switch ($node['diffStatus']) {
                case 'updated':
                    $nodeValueCheckedOld = addSpacesIfValIsArr($node['nodeValueOld']);
                    $nodeValueCheckedNew = addSpacesIfValIsArr($node['nodeValueNew']);
                    return [
                        "- " . $node['nodeKey'] => $nodeValueCheckedOld,
                        "+ " . $node['nodeKey'] => $nodeValueCheckedNew
                    ];
                case 'deleted':
                    $nodeValueChecked = addSpacesIfValIsArr($node['nodeValue']);
                    return ["- " . $node['nodeKey'] => $nodeValueChecked];
                case 'added':
                    $nodeValueChecked = addSpacesIfValIsArr($node['nodeValue']);
                    return ["+ " . $node['nodeKey'] => $nodeValueChecked];
                case 'unchanged':
                    $nodeValueChecked = addSpacesIfValIsArr($node['nodeValue']);
                    return ["  " . $node['nodeKey'] => $nodeValueChecked];
            }
        } else {
            $childRecurs = stylishMapping($node['child']);
            return ["  " . $node['nodeKey'] => $childRecurs];
        }
    }, $resultDiffArr);
    $flattenedStylishResult = array_reduce($stylishResult, fn($res, $val) => $res + $val, []);
    return $flattenedStylishResult;
}

function addSpacesIfValIsArr(mixed $nodeValue): mixed
{
    if (is_array($nodeValue)) {
        $spacedResult = array_map(function (mixed $key, mixed $val): array {
            $spacedValue = (is_array($val)) ? addSpacesIfValIsArr($val) : $val;
            return ["  $key" => $spacedValue];
        }, array_keys($nodeValue), array_values($nodeValue));
        $flattenedSpacedResult = array_reduce($spacedResult, fn($res, $val) => $res + $val, []);
        return $flattenedSpacedResult;
    }
    return $nodeValue;
}
