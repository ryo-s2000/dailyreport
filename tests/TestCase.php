<?php

namespace Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    protected function setUp(): void
    {
        $this->touchSqliteFile();

        parent::setUp();
    }

    private function touchSqliteFile()
    {
        echo exec('touch database/database.sqlite');
    }
}
