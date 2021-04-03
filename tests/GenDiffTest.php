<?php

//Модуль тестирования вычисления отличий 2-ух массивов

namespace Differ\Differ;

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
    [0] => Array
        (
            [nodeKey] => common
            [child] => Array
                (
                    [0] => Array
                        (
                            [nodeKey] => follow
                            [nodeValue] => 
                            [diffStatus] => added
                        )

                    [1] => Array
                        (
                            [nodeKey] => setting1
                            [nodeValue] => Value 1
                            [diffStatus] => unchanged
                        )

                    [2] => Array
                        (
                            [nodeKey] => setting2
                            [nodeValue] => 200
                            [diffStatus] => deleted
                        )

                    [3] => Array
                        (
                            [nodeKey] => setting3
                            [nodeValueOld] => 1
                            [nodeValueNew] => 
                            [diffStatus] => updated
                        )

                    [4] => Array
                        (
                            [nodeKey] => setting4
                            [nodeValue] => blah blah
                            [diffStatus] => added
                        )

                    [5] => Array
                        (
                            [nodeKey] => setting5
                            [nodeValue] => Array
                                (
                                    [key5] => value5
                                )

                            [diffStatus] => added
                        )

                    [6] => Array
                        (
                            [nodeKey] => setting6
                            [child] => Array
                                (
                                    [0] => Array
                                        (
                                            [nodeKey] => doge
                                            [child] => Array
                                                (
                                                    [0] => Array
                                                        (
                                                            [nodeKey] => wow
                                                            [nodeValueOld] => 
                                                            [nodeValueNew] => so much
                                                            [diffStatus] => updated
                                                        )

                                                )

                                        )

                                    [1] => Array
                                        (
                                            [nodeKey] => key
                                            [nodeValue] => value
                                            [diffStatus] => unchanged
                                        )

                                    [2] => Array
                                        (
                                            [nodeKey] => ops
                                            [nodeValue] => vops
                                            [diffStatus] => added
                                        )

                                )

                        )

                )

        )

    [1] => Array
        (
            [nodeKey] => group1
            [child] => Array
                (
                    [0] => Array
                        (
                            [nodeKey] => baz
                            [nodeValueOld] => bas
                            [nodeValueNew] => bars
                            [diffStatus] => updated
                        )

                    [1] => Array
                        (
                            [nodeKey] => foo
                            [nodeValue] => bar
                            [diffStatus] => unchanged
                        )

                    [2] => Array
                        (
                            [nodeKey] => nest
                            [nodeValueOld] => Array
                                (
                                    [key] => value
                                )

                            [nodeValueNew] => str
                            [diffStatus] => updated
                        )

                )

        )

    [2] => Array
        (
            [nodeKey] => group2
            [nodeValue] => Array
                (
                    [abc] => 12345
                    [deep] => Array
                        (
                            [id] => 45
                        )

                )

            [diffStatus] => deleted
        )

    [3] => Array
        (
            [nodeKey] => group3
            [nodeValue] => Array
                (
                    [deep] => Array
                        (
                            [id] => Array
                                (
                                    [number] => 45
                                )

                        )

                    [fee] => 100500
                )

            [diffStatus] => added
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
