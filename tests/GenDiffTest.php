<?php

//Модуль тестирования вычисления отличий 2-ух массивов

namespace Projects\lvl2;

use PHPUnit\Framework\TestCase;

class GenDiffTest extends TestCase
{
    private array $genDiffTestResult;

    /**
     * @dataProvider rightResultAndEntranceArrs
     */
    public function testGenDiff(string $genDiffRightResult, string $arr1, string $arr2): void
    {
        $this->genDiffTestResult = genDiffFromArrays(
            json_decode($arr1, true),
            json_decode($arr2, true)
        );
        $this->expectOutputString($genDiffRightResult);
        print_r($this->genDiffTestResult);
    }

    public function rightResultAndEntranceArrs()
    {
        return [
            ['Array
(
    [  common] => Array
        (
            [+ follow] => 
            [  setting1] => Value 1
            [- setting2] => 200
            [- setting3] => 1
            [+ setting3] => 
            [+ setting4] => blah blah
            [+ setting5] => Array
                (
                    [  key5] => value5
                )

            [  setting6] => Array
                (
                    [  doge] => Array
                        (
                            [- wow] => 
                            [+ wow] => so much
                        )

                    [  key] => value
                    [+ ops] => vops
                )

        )

    [  group1] => Array
        (
            [- baz] => bas
            [+ baz] => bars
            [  foo] => bar
            [- nest] => Array
                (
                    [  key] => value
                )

            [+ nest] => str
        )

    [- group2] => Array
        (
            [  abc] => 12345
            [  deep] => Array
                (
                    [  id] => 45
                )

        )

    [+ group3] => Array
        (
            [  deep] => Array
                (
                    [  id] => Array
                        (
                            [  number] => 45
                        )

                )

            [  fee] => 100500
        )

)
', '{
  "common": {
    "setting1": "Value 1",
    "setting2": 200,
    "setting3": true,
    "setting6": {
      "key": "value",
      "doge": {
        "wow": ""
      }
    }
  },
  "group1": {
    "baz": "bas",
    "foo": "bar",
    "nest": {
      "key": "value"
    }
  },
  "group2": {
    "abc": 12345,
    "deep": {
      "id": 45
    }
  }
}
', '{
  "common": {
    "follow": false,
    "setting1": "Value 1",
    "setting3": null,
    "setting4": "blah blah",
    "setting5": {
      "key5": "value5"
    },
    "setting6": {
      "key": "value",
      "ops": "vops",
      "doge": {
        "wow": "so much"
      }
    }
  },
  "group1": {
    "foo": "bar",
    "baz": "bars",
    "nest": "str"
  },
  "group3": {
    "deep": {
      "id": {
        "number": 45
      }
    },
    "fee": 100500
  }
}
']];
    }
}
