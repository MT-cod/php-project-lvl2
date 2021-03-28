<?php

namespace Differ\Differ;

function jsonFormattingOfDiffResult(array $resultArray): string
{
    return json_encode($resultArray, JSON_PRETTY_PRINT);
}
