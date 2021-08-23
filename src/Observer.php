<?php

namespace Dbt\Blame;

use Illuminate\Config\Repository;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Observer
{

    public function __construct (
        private Guard $auth,
        private Repository $config
    ) {}

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

            /*
             * We need to prevent the model from firing an updated event when
             * calling save(), which would otherwise happen.
             */
            Model::withoutEvents(function () use ($mutator, $model) {
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
