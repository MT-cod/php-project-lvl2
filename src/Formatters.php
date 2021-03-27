<?php

namespace Projects\lvl2;

function resultArrayToResultString(array $resultArray, string $format): string
{
    switch ($format) {
        case 'stylish':
            $resultArray =  json_encode(stylishFormattingOfDiffResult($resultArray), JSON_PRETTY_PRINT) . "\n";
            return preg_filter("/  \"|\"|\,/", '', $resultArray);
        case 'plain':
            return plainFormattingOfDiffResult($resultArray);
        case 'json':
            return jsonFormattingOfDiffResult($resultArray);
        default:
            exit("\nError. Unrecognised type of format ($format).\n");
    }
}
