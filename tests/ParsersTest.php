<?php

//Модуль тестирования парсингов файлов в массивы

namespace Projects\lvl2;

use PHPUnit\Framework\TestCase;

class ParsersTest extends TestCase
{
    private array $ParseJsonTestResult;
    private array $ParseYamlTestResult;
    private static string $parseFileRightResult = 'Array
(
    [host] => hexlet.io
    [timeout] => 50
    [proxy] => 123.234.53.22
    [follow] => 
)
';

    public function testParsingJson(): void
    {
        $this->ParseJsonTestResult = getAssocArrayFromFile(__DIR__ . '/fixtures/file1.json');
        $this->expectOutputString(static::$parseFileRightResult);
        print_r($this->ParseJsonTestResult);
    }

    public function testParsingYaml(): void
    {
        $this->ParseYamlTestResult = getAssocArrayFromFile(__DIR__ . '/fixtures/file1.yaml');
        $this->expectOutputString(static::$parseFileRightResult);
        print_r($this->ParseYamlTestResult);
    }
}
