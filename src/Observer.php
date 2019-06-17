<?php

namespace Dbt\Blame;

use Illuminate\Auth\Authenticatable;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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
        if (method_exists($model, 'bootSoftDelete')) {
            $mutator = new Mutator($this->auth, $this->config, $model, 'deleting');

            $mutator->mutate();
            $model->save();
        }
    }
}
