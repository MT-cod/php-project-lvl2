<?php

namespace Differ\Differ;

function stylishFormattingOfDiffResult(array $resultDiffArr): string
{
    $stylishResultArray = json_encode(stylishMapping($resultDiffArr), JSON_PRETTY_PRINT);
    return preg_filter("/  \"|\"|\,/", '', $stylishResultArray);
}

function stylishMapping(array $resultDiffArr): array
{
    return array_reduce(array_keys($resultDiffArr), function ($stylishResult, $key) use ($resultDiffArr) {
        if (array_key_exists('diffStatus', $resultDiffArr[$key])) {
            switch ($resultDiffArr[$key]['diffStatus']) {
                case 'updated':
                    $stylishResult["- $key"] = addSpacesIfValIsArr($resultDiffArr[$key]['oldValue']);
                    $stylishResult["+ $key"] = addSpacesIfValIsArr($resultDiffArr[$key]['newValue']);
                    break;
                case 'deleted':
                    $stylishResult["- $key"] = addSpacesIfValIsArr($resultDiffArr[$key]['value']);
                    break;
                case 'added':
                    $stylishResult["+ $key"] = addSpacesIfValIsArr($resultDiffArr[$key]['value']);
                    break;
                case 'unchanged':
                    $stylishResult["  $key"] = addSpacesIfValIsArr($resultDiffArr[$key]['value']);
            }
        } else {
            $stylishResult["  $key"] = stylishMapping($resultDiffArr[$key]);
        }
        return $stylishResult;
    }, []);
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
