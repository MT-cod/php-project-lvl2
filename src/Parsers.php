<?php

namespace Differ\Differ;

//Возвращаем ассоциативный массив из переданного файла определённого формата
function getAssocArrayFromFile(string $path): mixed
{
    $formatOfFile = checkFormatOfFile($path);
    switch ($formatOfFile) {
        case 'json':
            return json_decode(file_get_contents($path), true);
        case 'yaml':
            return \Symfony\Component\Yaml\Yaml::parseFile($path);
        default:
            exit("\nError. Unrecognised type of file ($path).\n");
    }
}

//Определяем формат переданного файла по его расширению
function checkFormatOfFile(string $path): string
{
    $pathInfo = pathinfo($path);
    return $pathInfo['extension'];
}
