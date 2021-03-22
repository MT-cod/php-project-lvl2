<?php

namespace Projects\lvl2;

function resultArrayToResultString(array $resultArray, string $format): string
{
    switch ($format) {
        case 'stylish':
            return stylishFormattingOfDiffResult($resultArray);
        case 'plain':
            return plainFormattingOfDiffResult($resultArray);
        default:
            exit("\nError. Unrecognised type of format ($format).\n");
    }
}