<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Storage;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected bool $seed = true;

    protected function tearDown(): void
    {
        Storage::disk('public')->deleteDirectory('.');

        parent::tearDown();
    }
}
