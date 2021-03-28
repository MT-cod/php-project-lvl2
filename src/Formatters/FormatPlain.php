<?php

namespace Projects\lvl2;

function plainFormattingOfDiffResult(array $resultArray, string $parents = '', array &$plainResultArr = []): string
{
    foreach ($resultArray as $key => $item) {
        if (array_key_exists('diffStatus', $item)) {
            switch ($item['diffStatus']) {
                case 'updated':
                    $oldValue = simplOrCompVal($item['oldValue']);
                    $newValue = simplOrCompVal($item['newValue']);
                    $plainResultArr[] = "Property '$parents$key' was updated. From $oldValue to $newValue";
                    break;
                case 'deleted':
                    $plainResultArr[] = "Property '$parents$key' was removed";
                    break;
                case 'added':
                    $value = simplOrCompVal($item['value']);
                    $plainResultArr[] = "Property '$parents$key' was added with value: $value";
            }
        } else {
            $parentsForIter = "$parents$key.";
            plainFormattingOfDiffResult($item, $parentsForIter, $plainResultArr);
        }
    }
    return implode("\n", $plainResultArr) . "\n";
}

function simplOrCompVal(mixed $value): mixed
{
    return (is_array($value)) ? '[complex value]' : ifBoolOr0ToString($value);
}

function ifBoolOr0ToString(mixed $value): mixed
{
    if ($value === true) {
        return 'true';
    } elseif ($value === false) {
        return 'false';
    } elseif ($value === null) {
        return 'null';
    }
    return "'$value'";
}
