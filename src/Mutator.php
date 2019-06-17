<?php

namespace Dbt\Blame;

use Illuminate\Config\Repository;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\Eloquent\Model;

class Mutator
{
    /** @var \Illuminate\Database\Eloquent\Model */
    private $model;

    /** @var string */
    private $event;

    /** @var \Illuminate\Config\Repository */
    private $config;

    /** @var \Illuminate\Contracts\Auth\Guard */
    private $auth;

    public function __construct (Guard $auth, Repository $config, Model $model, string $event)
    {
        $this->model = $model;
        $this->event = $event;
        $this->config = $config;
        $this->auth = $auth;
    }

    public function mutate (): void
    {
        if ($this->shouldMutate()) {
            $this->model->{$this->column()} = $this->auth->id();
        }
    }

    private function shouldMutate (): bool
    {
        return !$this->model->isDirty([$this->column()]);
    }

    private function column (): string
    {
        return $this->config->get('blame.columns.' . $this->event);
    }
}
