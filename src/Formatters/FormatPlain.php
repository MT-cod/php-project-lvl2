<?php

namespace Projects\lvl2;

function plainFormattingOfDiffResult(array $resultArray, $parents = '', &$plainResultArr = []): string
{
    foreach ($resultArray as $key => $value) {
        $diffCriteria = $key[0];
        $keyName = substr($key, 2);
        switch ($diffCriteria) {
            case '+':
                if (isset($lastDiff) && isset($lastDiff['lastKey']) && $lastDiff['lastKey'] == "$parents$keyName") {
                        $value = (is_array($value)) ? '[complex value]' : ifBoolOr0ToString($value);
                        $lastValue = (is_array($lastDiff['lastValue'])) ? '[complex value]' : ifBoolOr0ToString(
                            $lastDiff['lastValue']
                        );
                        array_pop($plainResultArr);
                        $plainResultArr[] = "Property '$parents$keyName' was updated. From $lastValue to $value";
                } else {
                    $value = (is_array($value)) ? '[complex value]' : ifBoolOr0ToString($value);
                    $plainResultArr[] = "Property '$parents$keyName' was added with value: $value";
                }
                $lastDiff = [];
                break;
            case '-':
                $plainResultArr[] = "Property '$parents$keyName' was removed";
                $lastDiff['lastKey'] = "$parents$keyName";
                $lastDiff['lastValue'] = $value;
                break;
            case ' '://Вложенка - на рекурсию
                if (is_array($value)) {
                    $parentsForIter = "$parents$keyName.";
                    $lastDiff = [];
                    plainFormattingOfDiffResult($value, $parentsForIter, $plainResultArr);
                }
        }
    }
    return implode("\n", $plainResultArr) . "\n";
}

//Проверяем, если значение булево или ноль, то возвращаем его эквивалент в строке
function ifBoolOr0ToString(mixed $value): mixed
{
    if ($value === true) {
        return 'true';
    } elseif ($value === false) {
        return 'false';
    } elseif ($value === null) {
        return 'null';
    } else {
        return "'$value'";
    }
}
