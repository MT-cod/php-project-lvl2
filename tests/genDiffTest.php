<?php

namespace Projects\lvl2;

use PHPUnit\Framework\TestCase;

class TestSolution extends TestCase
{
    public $result;

    public function testGenDiff()
    {
        $this->$result = '{
- follow: false
  host: hexlet.io
- proxy: 123.234.53.22
- timeout: 50
+ timeout: 20
+ verbose: true
}';
        $this->assertEquals($this->$result, shell_exec('/../bin/gendiff fixtures/file1.json fixtures/file2.json)');
    }
}
