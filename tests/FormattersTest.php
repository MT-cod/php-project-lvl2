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
     * @dataProvider rightResultsAndEntranceArr
     */
    public function testFormatOutput(string $rightResultOfStylishFormatOutput, string $rightResultOfPlainFormatOutput)
    {
        $this->genDiffResultArr = json_decode(file_get_contents(
            __DIR__ . '/fixtures/genDiffResultArr.json'
        ), true);

        $this->StylishFormatTestResult = resultArrayToResultString($this->genDiffResultArr, 'stylish');
        $this->assertEquals($rightResultOfStylishFormatOutput, $this->StylishFormatTestResult);
        /*$this->PlainFormatTestResult = resultArrayToResultString($this->genDiffResultArr, 'plain');
        $this->assertEquals($rightResultOfPlainFormatOutput, $this->PlainFormatTestResult);*/
    }

    public function rightResultsAndEntranceArr()
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
}', '']];
    }
}
