<?php

namespace Differ\Differ;

function jsonFormattingOfDiffResult(array $resultDiffArr): string | bool
{
    return json_encode($resultDiffArr, JSON_PRETTY_PRINT);
}
