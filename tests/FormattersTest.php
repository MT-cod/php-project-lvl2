<?php

//Модуль тестирования форматтеров вывода результата работы программы

namespace Projects\lvl2;

use PHPUnit\Framework\TestCase;

class FormattersTest extends TestCase
{
    private array $genDiffResultArr;
    private string $StylishFormatTestResult;
    private string $PlainFormatTestResult;

    /**
     * @dataProvider rightResults
     */
    public function testFormatOutput(string $rightResultOfStylishFormatOutput, string $rightResultOfPlainFormatOutput)
    {
        $this->genDiffResultArr = json_decode(file_get_contents(
            __DIR__ . '/fixtures/genDiffResultArr.json'
        ), true);

        $this->StylishFormatTestResult = resultArrayToResultString($this->genDiffResultArr, 'stylish');
        $this->assertEquals($rightResultOfStylishFormatOutput, $this->StylishFormatTestResult);
        $this->PlainFormatTestResult = resultArrayToResultString($this->genDiffResultArr, 'plain');
        $this->assertEquals($rightResultOfPlainFormatOutput, $this->PlainFormatTestResult);
    }

    public function rightResults()
    {
        return [
            ['{
    common: {
      + follow: false
        setting1: Value 1
      - setting2: 200
      - setting3: true
      + setting3: null
      + setting4: blah blah
      + setting5: {
            key5: value5
        }
        setting6: {
            doge: {
              - wow: 
              + wow: so much
            }
            key: value
          + ops: vops
        }
    }
    group1: {
      - baz: bas
      + baz: bars
        foo: bar
      - nest: {
            key: value
        }
      + nest: str
    }
  - group2: {
        abc: 12345
        deep: {
            id: 45
        }
    }
  + group3: {
        deep: {
            id: {
                number: 45
            }
        }
        fee: 100500
    }
}', "Property 'common.follow' was added with value: false
Property 'common.setting2' was removed
Property 'common.setting3' was updated. From true to null
Property 'common.setting4' was added with value: 'blah blah'
Property 'common.setting5' was added with value: [complex value]
Property 'common.setting6.doge.wow' was updated. From '' to 'so much'
Property 'common.setting6.ops' was added with value: 'vops'
Property 'group1.baz' was updated. From 'bas' to 'bars'
Property 'group1.nest' was updated. From [complex value] to 'str'
Property 'group2' was removed
Property 'group3' was added with value: [complex value]"]];
    }
}
