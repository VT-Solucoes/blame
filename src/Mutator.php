<?php

namespace Dbt\Blame;

use Illuminate\Config\Repository;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Database\Eloquent\Model;

class Mutator
{

    public function __construct (
        private Guard $auth,
        private Repository $config,
        private Model $model,
        private string $event
    ) {}

    public function mutate (): void
    {
        if (!$this->shouldMutate()) {
            return;
        }

        $this->model->{$this->column()} = $this->getId();
    }

    private function getId (): ?int
    {
        return $this->getAuthId() ?? $this->defaultId();
    }

    private function getAuthId (): ?int
    {
        $id = $this->auth->id();

        return $id ? (int) $id : null;
    }

    private function defaultId (): ?int
    {
        return $this->config->get('blame.user.default_id');
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
