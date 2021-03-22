<?php

namespace Projects\lvl2;

function stylishFormattingOfDiffResult(array $resultArray): string
{
    $stylishResult = json_encode($resultArray, JSON_PRETTY_PRINT);
    $stylishResult = preg_filter("/  \"|\"|\,/", '', $stylishResult);
    return $stylishResult;
}
