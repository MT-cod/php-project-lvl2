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

function addSpacesIfValIsArr(mixed $item): mixed
{
    if (is_array($item)) {
        return array_reduce(array_keys($item), function ($spacedResult, $key) use ($item) {
            $spacedResult['  ' . $key] = (is_array($item[$key])) ? addSpacesIfValIsArr($item[$key]) : $item[$key];
            return $spacedResult;
        }, []);
    }
    return $item;
}
