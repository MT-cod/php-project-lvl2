<?php

namespace Differ\Differ;

function resultArrayToResultString(array $resultDiffArr, string $format): string
{
    switch ($format) {
        case 'stylish':
            return stylishFormattingOfDiffResult($resultDiffArr);
        case 'plain':
            return plainFormattingOfDiffResult($resultDiffArr);
        case 'json':
            return jsonFormattingOfDiffResult($resultDiffArr);
        default:
            exit("\nError. Unrecognised type of format ($format).\n");
    }
}
