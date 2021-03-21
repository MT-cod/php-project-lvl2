<?php

namespace Projects\lvl2;

//Возвращаем результат в строчном виде
function resultArrayToResultString(array $resultArray, string $format): string
{

    return plainFormattingOfDiffResult($resultArray);
}