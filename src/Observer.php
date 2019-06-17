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

    public function creating (Model $model)
    {
        $mutator = new Mutator($this->auth, $this->config, $model, 'creating');

        $mutator->mutate();
    }

    public function updating (Model $model)
    {
        $mutator = new Mutator($this->auth, $this->config, $model, 'updating');

        $mutator->mutate();
    }

    public function deleting (Model $model)
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

    private function usesSoftDeletes (Model $model)
    {
        return in_array(SoftDeletes::class, $this->deepUse($model));
    }

    private function deepUse (Model $model) {
        $traits = [];

        do {
            $traits = array_merge(class_uses($model), $traits);
        } while ($model = get_parent_class($model));

        foreach ($traits as $trait => $same) {
            $traits = array_merge(class_uses($trait), $traits);
        }

        return array_unique($traits);
    }
}
