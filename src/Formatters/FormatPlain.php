<?php

namespace Projects\lvl2;

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