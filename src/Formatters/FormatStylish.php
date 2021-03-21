<?php

namespace Projects\lvl2;

function plainFormattingOfDiffResult(array $resultArray)
{
    $res = json_encode($resultArray, JSON_PRETTY_PRINT);
    $res = preg_filter("/  \"|\"|\,/", '', $res);
    return $res;
}
