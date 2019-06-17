<?php

namespace Dbt\Blame;

use Illuminate\Config\Repository;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Observer
{
    /** @var \Illuminate\Config\Repository */
    private $config;

    /** @var \Illuminate\Contracts\Auth\Guard */
    private $auth;

    public function __construct (Guard $auth, Repository $config)
    {
        $this->config = $config;
        $this->auth = $auth;
    }

    public function creating (Model $model): void
    {
        $mutator = new Mutator($this->auth, $this->config, $model, 'creating');

        $mutator->mutate();
    }

    public function updating (Model $model): void
    {
        $mutator = new Mutator($this->auth, $this->config, $model, 'updating');

        $mutator->mutate();
    }

    public function deleting (Model $model): void
    {
        if ($this->usesSoftDeletes($model)) {
            $mutator = new Mutator($this->auth, $this->config, $model, 'deleting');

            /**
             * We need to prevent the model from firing an updated event when
             * calling save(), which would otherwise happen.
             */
            WithoutEvents::run(function () use ($mutator, $model) {
                $mutator->mutate();
                $model->save();
            });
        }
    }

    private function usesSoftDeletes (Model $model): bool
    {
        return in_array(SoftDeletes::class, class_uses_deep($model));
    }
}
