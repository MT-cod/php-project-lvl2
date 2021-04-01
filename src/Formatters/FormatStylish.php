<?php

namespace Differ\Differ;

function stylishFormattingOfDiffResult(array $resultDiffArr): array | string | null
{
    $stylishResultArray = json_encode(stylishMapping($resultDiffArr), JSON_PRETTY_PRINT);
    if ($stylishResultArray === false) {
        exit('Stylish encode to json failed');
    }
    return preg_filter("/  \"|\"|\,/", '', $stylishResultArray);
}

function stylishMapping(array $resultDiffArr): array
{
    $stylishResult = array_map(function (mixed $nodeKey,mixed  $nodeValue): mixed {
        if (array_key_exists('diffStatus', $nodeValue)) {
            switch ($nodeValue['diffStatus']) {
                case 'updated':
                    $nodeValueCheckedOld = addSpacesIfValIsArr($nodeValue['oldValue']);
                    $nodeValueCheckedNew = addSpacesIfValIsArr($nodeValue['newValue']);
                    return ["- $nodeKey" => $nodeValueCheckedOld, "+ $nodeKey" => $nodeValueCheckedNew];
                case 'deleted':
                    $nodeValueChecked = addSpacesIfValIsArr($nodeValue['value']);
                    return ["- $nodeKey" => $nodeValueChecked];
                case 'added':
                    $nodeValueChecked = addSpacesIfValIsArr($nodeValue['value']);
                    return ["+ $nodeKey" => $nodeValueChecked];
                case 'unchanged':
                    $nodeValueChecked = addSpacesIfValIsArr($nodeValue['value']);
                    return ["  $nodeKey" => $nodeValueChecked];
            }
        } else {
            $nodeValueRecurs = stylishMapping($nodeValue);
            return ["  $nodeKey" => $nodeValueRecurs];
        }
    }, array_keys($resultDiffArr), array_values($resultDiffArr));
    $flattenedStylishResult = array_reduce($stylishResult, fn($res, $arr) => $res + $arr, []);
    return $flattenedStylishResult;
}

function addSpacesIfValIsArr(mixed $nodeValue): mixed
{
    if (is_array($nodeValue)) {
        $spacedResult = array_map(function (mixed $key, mixed $val): array {
            $spacedValue = (is_array($val)) ? addSpacesIfValIsArr($val) : $val;
            return ["  $key" => $spacedValue];
        }, array_keys($nodeValue), array_values($nodeValue));
        $flattenedSpacedResult = array_reduce($spacedResult, fn($res, $arr) => $res + $arr, []);
        return $flattenedSpacedResult;
    }
    return $nodeValue;
}
