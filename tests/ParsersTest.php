<?php

namespace Projects\lvl2;

use PHPUnit\Framework\TestCase;

class ParsersTest extends TestCase
{
    /**
     * @covers ::getAssocArrayFromFile
     * @dataProvider setProv
     */
    public function testParsingJson($ParseFileRightResult): void
    {
        $this->ParseJsonTestResult = getAssocArrayFromFile(__DIR__ . '/fixtures/file1.json');
        $this->expectOutputString($ParseFileRightResult);
        print_r($this->ParseJsonTestResult);
    }

    /**
     * @covers ::getAssocArrayFromFile
     * @dataProvider setProv
     */
    public function testParsingYaml($ParseFileRightResult): void
    {
        $this->ParseYamlTestResult = getAssocArrayFromFile(__DIR__ . '/fixtures/file1.yaml');
        $this->expectOutputString($ParseFileRightResult);
        print_r($this->ParseYamlTestResult);
    }

    public function setProv()
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
