<?php

namespace Projects\lvl2;

function plainFormattingOfDiffResult(array $resultArray, string $parents = '', array &$plainResultArr = []): string
{
    foreach ($resultArray as $key => $item) {
        if (array_key_exists('diffStatus', $item)) {
            switch ($item['diffStatus']) {
                case 'updated':
                    $oldValue = (is_array($item['oldValue'])) ? '[complex value]' : ifBoolOr0ToString(
                        $item['oldValue']
                    );
                    $newValue = (is_array($item['newValue'])) ? '[complex value]' : ifBoolOr0ToString(
                        $item['newValue']
                    );
                    $plainResultArr[] = "Property '$parents$key' was updated. From $oldValue to $newValue";
                    break;
                case 'deleted':
                    $plainResultArr[] = "Property '$parents$key' was removed";
                    break;
                case 'added':
                    $value = (is_array($item['value'])) ? '[complex value]' : ifBoolOr0ToString($item['value']);
                    $plainResultArr[] = "Property '$parents$key' was added with value: $value";
            }
        } else {
            $parentsForIter = "$parents$key.";
            plainFormattingOfDiffResult($item, $parentsForIter, $plainResultArr);
        }
    }
    return implode("\n", $plainResultArr) . "\n";
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
