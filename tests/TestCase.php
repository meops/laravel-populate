<?php

namespace Meops\Populate\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Meops\Populate\PopulateServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    use RefreshDatabase;
    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate', [
            '--database' => 'testing',
            '--path' => __DIR__ . '/Migrations/users.php',
            '--realpath' => true,
        ]);
    }

    protected function getPackageProviders($app): array
    {
        return [
            PopulateServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app): void
    {
        $app['config']->set('database.default', 'testing');
    }
}