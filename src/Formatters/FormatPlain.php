<?php

namespace Projects\lvl2;

function plainFormattingOfDiffResult(array $resultArray): string
{
    $res = json_encode($resultArray, JSON_PRETTY_PRINT);
    $res = preg_filter("/  \"|\"|\,/", '', $res);
    return $res;
    /*    foreach ($resultArray as $key => $value) {
            if (!is_array($value)) {
                $res .=  "$spacing$key: " . ifBoolOr0ToString($value) . "\n";
            } else {
                //Если значение по ключу вложенный массив, то проходимся по этому массиву
                //этой же функцией для приведения к строчному виду
                $res .= "$spacing$key: {\n" . resultArrayToResultString($value, $spacing = $spacing . "  ");
                $res .= "$spacing}\n";
                $spacing = substr_replace($spacing, "  ", 0);
            }
        }*/
}

//Проверяем, если значение булево или ноль, то возвращаем его эквивалент в строке
/*function ifBoolOr0ToString(mixed $value): mixed
{
    if ($value === true) {
        return 'true';
    } elseif ($value === false) {
        return 'false';
    } elseif ($value === null) {
        return 'null';
    } else {
        return $value;
    }
}*/