<?php

namespace Dbt\Tests;

use Dbt\Blame\Provider;
use Dbt\Tests\Fixtures\ModelFixture;
use Illuminate\Database\Schema\Blueprint;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    /** @var \Illuminate\Database\Schema\Builder */
    private $schema;

    public function setUp (): void
    {
        parent::setUp();

        $this->schema = $this->app->make('db')
            ->connection()
            ->getSchemaBuilder();

        $this->withFactories(__DIR__ . '/../resources/factories');

        $this->migrateDatabase();
    }

    protected function getEnvironmentSetUp ($app): void
    {
        $app['config']->set('m.classes', [
            ModelFixture::class,
        ]);

        $app['config']->set('app.debug', 'true');
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    protected function getPackageProviders ($app): array
    {
        return [Provider::class];
    }

    private function migrateDatabase (): void
    {
        $this->schema->create('blame', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->timestamps();
        });
    }
}
