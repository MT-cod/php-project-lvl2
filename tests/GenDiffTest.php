<?php

namespace Projects\lvl2;

use PHPUnit\Framework\TestCase;

class GenDiffTest extends TestCase
{
    public $rightResult;
    public $runDiffResult;

    public function testGenDiff()
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
        $this->runDiffResult = shell_exec(
            'php ' . __DIR__ . '/../bin/gendiff ' . __DIR__ . '/fixtures/file1.json ' . __DIR__ . '/fixtures/file2.json'
        );
        $this->assertEquals($this->rightResult, $this->runDiffResult);
    }
}
