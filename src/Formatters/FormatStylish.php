<?php

namespace Differ\Differ;

function stylishFormattingOfDiffResult(array $resultArray): string
{
    $stylishResultArray = json_encode(stylishMapping($resultArray), JSON_PRETTY_PRINT);
    return preg_filter("/  \"|\"|\,/", '', $stylishResultArray);
}

function stylishMapping(array $resultArray, array $stylishResult = []): array
{
    array_walk($resultArray, function ($item, $key) use (&$stylishResult) {
        if (array_key_exists('diffStatus', $item)) {
            switch ($item['diffStatus']) {
                case 'updated':
                    $stylishResult["- $key"] = addSpacesIfValIsArr($item['oldValue']);
                    $stylishResult["+ $key"] = addSpacesIfValIsArr($item['newValue']);
                    break;
                case 'deleted':
                    $stylishResult["- $key"] = addSpacesIfValIsArr($item['value']);
                    break;
                case 'added':
                    $stylishResult["+ $key"] = addSpacesIfValIsArr($item['value']);
                    break;
                case 'unchanged':
                    $stylishResult["  $key"] = addSpacesIfValIsArr($item['value']);
            }
        } else {
            $stylishResult["  $key"] = stylishMapping($item);
        }
    });
    return $stylishResult;
}

function addSpacesIfValIsArr(mixed $item, array $spacedResult = []): mixed
{
    if (is_array($item)) {
        array_walk($item, function ($val, $key) use (&$spacedResult) {
            $spacedResult["  $key"] = (is_array($val)) ? addSpacesIfValIsArr($val) : $val;
        });
        return $spacedResult;
    }
    return $item;
}
