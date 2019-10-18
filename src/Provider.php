<?php

namespace Dbt\Blame;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ServiceProvider;

class Provider extends ServiceProvider
{
    public function register (): void
    {
        $this->publishes([
            __DIR__ . '/../config/blame.php' => config_path('blame.php'),
        ], 'config');

        $this->mergeConfigFrom(
            __DIR__ . '/../config/blame.php',
            'blame'
        );
    }

    public function boot (): void
    {
        $columns = $this->config('columns');

        Blueprint::macro('blameColumns', function () use ($columns) {
            foreach ($columns as $column) {
                /**
                 * @noinspection PhpUndefinedMethodInspection
                 * @psalm-suppress UndefinedMethod
                 */
                $this->unsignedBigInteger($column)->nullable();
            }
        });

        /** @var \Illuminate\Database\Eloquent\Model $model */
        foreach ($this->config('models') as $model) {
            $model::observe($this->config('observer'));
        }
    }

    /**
     * @return mixed
     */
    private function config (string $key)
    {
        return $this->app->make('config')->get('blame.' . $key);
    }
}
