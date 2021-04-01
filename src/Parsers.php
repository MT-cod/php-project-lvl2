<?php

namespace Differ\Differ;

//Возвращаем ассоциативный массив из переданного файла определённого формата
function getAssocArrayFromFile(string $path)
{
    $formatOfFile = checkFormatOfFile($path);
    switch ($formatOfFile) {
        case 'json':
            $jsonString = file_get_contents($path);
            if ($jsonString !== false) {
                return json_decode($jsonString, true);
            }
            break;
        case 'yaml':
            return \Symfony\Component\Yaml\Yaml::parseFile($path);
    }
    echo("\nFailed to load information from path ($path).\n");
    exit;
}

//Определяем формат переданного файла по его расширению
function checkFormatOfFile(string $path)
{
    return pathinfo($path, PATHINFO_EXTENSION);
}
