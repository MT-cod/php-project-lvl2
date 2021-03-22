<?php

//Модуль тестирования парсингов

namespace Projects\lvl2;

use PHPUnit\Framework\TestCase;

class ParsersTest extends TestCase
{
    public array $ParseJsonTestResult;
    public array $ParseYamlTestResult;

    /**
     * @dataProvider parseFileRightResult
     */
    public function testParsingJson(string $parseFileRightResult): void
    {
        $this->ParseJsonTestResult = getAssocArrayFromFile(__DIR__ . '/fixtures/file1.json');
        $this->expectOutputString($parseFileRightResult);
        print_r($this->ParseJsonTestResult);
    }

    /**
     * @dataProvider parseFileRightResult
     */
    public function testParsingYaml(string $parseFileRightResult): void
    {
        $this->ParseYamlTestResult = getAssocArrayFromFile(__DIR__ . '/fixtures/file1.yaml');
        $this->expectOutputString($parseFileRightResult);
        print_r($this->ParseYamlTestResult);
    }

    public function parseFileRightResult(): array
    {
        return [
            ['Array
(
    [host] => hexlet.io
    [timeout] => 50
    [proxy] => 123.234.53.22
    [follow] => 
)
']];
    }
}
