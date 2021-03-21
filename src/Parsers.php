<?php

namespace Projects\lvl2;

//Возвращаем ассоциативный массив из переданного файла определённого формата
function getAssocArrayFromFile(string $path): mixed
{
    $format_of_file = checkFormatOfFile($path);
    switch ($format_of_file) {
        case 'json':
            return json_decode(file_get_contents($path), true);
        case 'yaml':
            return \Symfony\Component\Yaml\Yaml::parseFile($path);
        default:
            exit("Error. Unrecognised type of file ($path).\n");
    }
}

//Определяем формат переданного файла по его расширению
function checkFormatOfFile(string $path): string
{
    $path_info = pathinfo($path);
    return $path_info['extension'];
}
