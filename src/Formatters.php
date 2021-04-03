<?php

namespace Differ\Differ;

function resultArrayToResultString(array $resultDiffArr, string $format): array | string | bool | null
{
    switch ($format) {
        case 'stylish':
            return stylishFormattingOfDiffResult($resultDiffArr);
        case 'plain':
            return plainFormattingOfDiffResult($resultDiffArr);
        case 'json':
            return jsonFormattingOfDiffResult($resultDiffArr);
        default:
            return "\nError. Unrecognised type of format ($format).\n";
    }
}
