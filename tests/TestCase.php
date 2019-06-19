<?php

namespace Dbt\Tests;

use Dbt\Blame\Observer;
use Dbt\Blame\Provider;
use Dbt\Tests\Fixtures\ModelFixture;
use Dbt\Tests\Fixtures\UserFixture;
use Illuminate\Database\Schema\Blueprint;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    /** @var \Illuminate\Database\Schema\Builder */
    private $schema;

    public function setUp (): void
    {
        parent::setUp();

        $this->schema = $this->app
            ->make('db')
            ->connection()
            ->getSchemaBuilder();

        $this->migrateDatabase();
    }

    protected function beUser (): UserFixture
    {
        $user = UserFixture::make();

        $this->be($user);

        return $user;
    }

    protected function beAnotherUser (): UserFixture
    {
        return $this->beUser();
    }

    protected function getEnvironmentSetUp ($app): void
    {
        $app['config']->set('blame', [
            'observer' => Observer::class,
            'user' => [
                'model' => UserFixture::class,
                'primary_key' => 'id',
                'default_id' => $this->getDefaultId(),
            ],
            'models' => [
                ModelFixture::class,
            ],
            'columns' => [
                'creating' => 'created_by',
                'updating' => 'updated_by',
                'deleting' => 'deleted_by',
            ],
        ]);

        $app['config']->set('app.debug', 'true');
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    protected function getDefaultId (): int
    {
        return 98765;
    }

    protected function unsetDefaultId (): void
    {
        $this->app['config']->set('blame.user.default_id', null);
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
            $table->blameColumns();
            $table->timestamps();
            $table->softDeletes();
        });

        $this->schema->create('user', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }
}
