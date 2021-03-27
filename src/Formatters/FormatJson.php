<?php

namespace Projects\lvl2;

function jsonFormattingOfDiffResult(array $resultArray, $parents = '', array &$jsonResultArr = []): string
{
    foreach ($resultArray as $key => $value) {
        $diffCriteria = $key[0];
        $keyName = substr($key, 2);
        switch ($diffCriteria) {
            case '+':
                if (isset($lastDiff) && isset($lastDiff['lastKey']) && $lastDiff['lastKey'] == $keyName) {
                    $lastValue = $lastDiff['lastValue'];
                    //unset($jsonResultArr['deleted'][$parents][$keyName]);
                    $jsonResultArr['updated'][$parents][$keyName]['old'] = $lastValue;
                    $jsonResultArr['updated'][$parents][$keyName]['new'] = sanitizeSpaces($value);
                } else {
                    $jsonResultArr['added'][$parents][$keyName] = sanitizeSpaces($value);
                }
                $lastDiff = [];
                break;
            case '-':
                $jsonResultArr['deleted'][$parents][$keyName] = sanitizeSpaces($value);
                $lastDiff['lastKey'] = "$parents$keyName";
                $lastDiff['lastValue'] = sanitizeSpaces($value);
                break;
            case ' ':
                if (is_array($value)) {//Вложенка - на рекурсию
                    $parentsForIter = "$parents$keyName.";
                    $lastDiff = [];
                    jsonFormattingOfDiffResult($value, $parentsForIteration, $jsonResultArr);
                } else {
                    $jsonResultArr['unchanged'][$parents][$keyName] = sanitizeSpaces($value);
                    $lastDiff = [];
                }
        }
    }
    ksort($jsonResultArr);
    return json_encode($jsonResultArr, JSON_PRETTY_PRINT) . "\n";
}

function sanitizeSpaces(mixed $item, array $sanResult = []): mixed
{
    if (is_array($item)) {
        foreach ($item as $key => $val) {
            $keyName = ($key[0] == ' ') ? substr($key, 2) : $key;
            $sanResult[$keyName] = (!is_array($val)) ? $val : sanitizeSpaces($val);
        }
        return $sanResult;
    }
    return $item;
}
