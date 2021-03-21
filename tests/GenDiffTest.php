<?php

namespace Projects\lvl2;

use PHPUnit\Framework\TestCase;

class GenDiffTest extends TestCase
{
    public $rightResult;
    public $recursRightResult;
    public $TestDiffResultJson;
    public $TestDiffResultYaml;

    public function testGenDiff(): void
    {
        $this->rightResult = '{
- follow: false
  host: hexlet.io
- proxy: 123.234.53.22
- timeout: 50
+ timeout: 20
+ verbose: true
}
';
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
        /*$this->TestDiffResultJson = shell_exec(
            'php ' . __DIR__ . '/../bin/gendiff ' . __DIR__ . '/fixtures/file1.json ' . __DIR__ . '/fixtures/file2.json'
        );
        $this->assertEquals($this->rightResult, $this->TestDiffResultJson);
        $this->TestDiffResultYaml = shell_exec(
            'php ' . __DIR__ . '/../bin/gendiff ' . __DIR__ . '/fixtures/file1.yaml ' . __DIR__ . '/fixtures/file2.yaml'
        );
        $this->assertEquals($this->rightResult, $this->TestDiffResultYaml);*/
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
}
