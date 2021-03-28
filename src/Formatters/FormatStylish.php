<?php

namespace Projects\lvl2;

function stylishFormattingOfDiffResult(array $resultArray): string
{
    $stylishResultArray = json_encode(stylishMapping($resultArray), JSON_PRETTY_PRINT) . "\n";
    return preg_filter("/  \"|\"|\,/", '', $stylishResultArray);
}

function stylishMapping(array $resultArray, array $stylishResult = []): array
{
    foreach ($resultArray as $key => $item) {
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
    }
    return $stylishResult;
}

function addSpacesIfValIsArr(mixed $item, array $spacedResult = []): mixed
{
    if (is_array($item)) {
        foreach ($item as $key => $val) {
            $spacedResult["  $key"] = (is_array($val)) ? addSpacesIfValIsArr($val) : $val;
        }
        return $spacedResult;
    }
    return $item;
}
