<?php

namespace Differ\Differ;

use function PHPUnit\Framework\isEmpty;

function plainFormattingOfDiffResult(array $resultDiffArr, string $parents = ''): string
{
    $plainResultArr = array_map(function ($node) use ($parents) {
        if (array_key_exists('diffStatus', $node)) {
            switch ($node['diffStatus']) {
                case 'updated':
                    $Old = simplOrCompVal($node['nodeValueOld']);
                    $New = simplOrCompVal($node['nodeValueNew']);
                    return "Property '$parents" . $node['nodeKey'] . "' was updated. From $Old to $New";
                case 'deleted':
                    return "Property '$parents" . $node['nodeKey'] . "' was removed";
                case 'added':
                    $nodeValue = simplOrCompVal($node['nodeValue']);
                    return "Property '$parents" . $node['nodeKey'] . "' was added with value: $nodeValue";
            }
        } else {
            $parentsForIter = $parents . $node['nodeKey'] . '.';
            return plainFormattingOfDiffResult($node['child'], $parentsForIter);
        }
    }, $resultDiffArr);
    $filteredPlainResultArr = array_filter($plainResultArr, fn($row) => $row != '');
    return implode("\n", $filteredPlainResultArr);
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
    } elseif ($value === 0) {
        return 0;
    }
    return "'$value'";
}
