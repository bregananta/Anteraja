<?php

namespace Bregananta\Anteraja\Tests;

use Bregananta\Anteraja\AnterajaBaseServiceProvider;
use Illuminate\Foundation\Application;

class TestCase extends \Orchestra\Testbench\TestCase
{
    /**
     * Get package providers.
     *
     * @param  Application  $app
     *
     * @return array<int, class-string>
     */
    protected function getPackageProviders($app): array
    {
        return [
            AnterajaBaseServiceProvider::class,
        ];
    }
}