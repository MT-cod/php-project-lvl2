<?php

namespace Projects\lvl2;

use PHPUnit\Framework\TestCase;

/*class GenDiffTest extends TestCase
{
    public $recursRightResult;

    public function testGenDiff(): void
    {
        $this->recursRightResult = '{
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
}';

        $this->TestDiffResultRecursJson = shell_exec(
            'php ' . __DIR__ . '/../bin/gendiff ' .
            __DIR__ . '/fixtures/recurs_file1.json ' . __DIR__ . '/fixtures/recurs_file2.json'
        );
        $this->assertEquals($this->recursRightResult, $this->TestDiffResultRecursJson);
        $this->TestDiffResultRecursYaml = shell_exec(
            'php ' . __DIR__ . '/../bin/gendiff ' .
            __DIR__ . '/fixtures/recurs_file1.yaml ' . __DIR__ . '/fixtures/recurs_file2.yaml'
        );
        $this->assertEquals($this->recursRightResult, $this->TestDiffResultRecursYaml);
    }
}*/
