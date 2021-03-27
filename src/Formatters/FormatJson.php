<?php

namespace Projects\lvl2;

function jsonFormattingOfDiffResult(array $resultArray): string
{
    return json_encode($resultArray, JSON_PRETTY_PRINT) . "\n";
}
