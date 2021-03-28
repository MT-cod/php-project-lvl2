<?php

//Модуль тестирования форматтеров вывода результата работы программы

namespace Projects\lvl2;

use PHPUnit\Framework\TestCase;

class FormattersTest extends TestCase
{
    private array $genDiffResultArr;
    private string $stylishFormatTestResult;
    private string $plainFormatTestResult;
    private string $jsonFormatTestResult;

    /**
     * @dataProvider rightResults
     */
    public function testFormatOutput(
        string $rightResultOfStylishFormatOutput,
        string $rightResultOfPlainFormatOutput,
        string $rightResultOfJsonFormatOutput,
        string $genDiffRightResultInJson
    ) {
        $this->genDiffResultArr = json_decode($genDiffRightResultInJson, true);

        $this->stylishFormatTestResult = resultArrayToResultString($this->genDiffResultArr, 'stylish');
        $this->assertEquals($rightResultOfStylishFormatOutput, $this->stylishFormatTestResult);
        $this->plainFormatTestResult = resultArrayToResultString($this->genDiffResultArr, 'plain');
        $this->assertEquals($rightResultOfPlainFormatOutput, $this->plainFormatTestResult);
        $this->jsonFormatTestResult = resultArrayToResultString($this->genDiffResultArr, 'json');
        $this->assertEquals($rightResultOfJsonFormatOutput, $this->jsonFormatTestResult);
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
}
', "Property 'common.follow' was added with value: false
Property 'common.setting2' was removed
Property 'common.setting3' was updated. From true to null
Property 'common.setting4' was added with value: 'blah blah'
Property 'common.setting5' was added with value: [complex value]
Property 'common.setting6.doge.wow' was updated. From '' to 'so much'
Property 'common.setting6.ops' was added with value: 'vops'
Property 'group1.baz' was updated. From 'bas' to 'bars'
Property 'group1.nest' was updated. From [complex value] to 'str'
Property 'group2' was removed
Property 'group3' was added with value: [complex value]
", '{
    "common": {
        "follow": {
            "diffStatus": "added",
            "value": false
        },
        "setting1": {
            "diffStatus": "unchanged",
            "value": "Value 1"
        },
        "setting2": {
            "diffStatus": "deleted",
            "value": 200
        },
        "setting3": {
            "diffStatus": "updated",
            "oldValue": true,
            "newValue": null
        },
        "setting4": {
            "diffStatus": "added",
            "value": "blah blah"
        },
        "setting5": {
            "diffStatus": "added",
            "value": {
                "key5": "value5"
            }
        },
        "setting6": {
            "doge": {
                "wow": {
                    "diffStatus": "updated",
                    "oldValue": "",
                    "newValue": "so much"
                }
            },
            "key": {
                "diffStatus": "unchanged",
                "value": "value"
            },
            "ops": {
                "diffStatus": "added",
                "value": "vops"
            }
        }
    },
    "group1": {
        "baz": {
            "diffStatus": "updated",
            "oldValue": "bas",
            "newValue": "bars"
        },
        "foo": {
            "diffStatus": "unchanged",
            "value": "bar"
        },
        "nest": {
            "diffStatus": "updated",
            "oldValue": {
                "key": "value"
            },
            "newValue": "str"
        }
    },
    "group2": {
        "diffStatus": "deleted",
        "value": {
            "abc": 12345,
            "deep": {
                "id": 45
            }
        }
    },
    "group3": {
        "diffStatus": "added",
        "value": {
            "deep": {
                "id": {
                    "number": 45
                }
            },
            "fee": 100500
        }
    }
}
', '{
    "common": {
        "follow": {
            "diffStatus": "added",
            "value": false
        },
        "setting1": {
            "diffStatus": "unchanged",
            "value": "Value 1"
        },
        "setting2": {
            "diffStatus": "deleted",
            "value": 200
        },
        "setting3": {
            "diffStatus": "updated",
            "oldValue": true,
            "newValue": null
        },
        "setting4": {
            "diffStatus": "added",
            "value": "blah blah"
        },
        "setting5": {
            "diffStatus": "added",
            "value": {
                "key5": "value5"
            }
        },
        "setting6": {
            "doge": {
                "wow": {
                    "diffStatus": "updated",
                    "oldValue": "",
                    "newValue": "so much"
                }
            },
            "key": {
                "diffStatus": "unchanged",
                "value": "value"
            },
            "ops": {
                "diffStatus": "added",
                "value": "vops"
            }
        }
    },
    "group1": {
        "baz": {
            "diffStatus": "updated",
            "oldValue": "bas",
            "newValue": "bars"
        },
        "foo": {
            "diffStatus": "unchanged",
            "value": "bar"
        },
        "nest": {
            "diffStatus": "updated",
            "oldValue": {
                "key": "value"
            },
            "newValue": "str"
        }
    },
    "group2": {
        "diffStatus": "deleted",
        "value": {
            "abc": 12345,
            "deep": {
                "id": 45
            }
        }
    },
    "group3": {
        "diffStatus": "added",
        "value": {
            "deep": {
                "id": {
                    "number": 45
                }
            },
            "fee": 100500
        }
    }
}
']];
    }
}
