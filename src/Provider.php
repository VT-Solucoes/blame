<?php

namespace Dbt\Blame;

use Illuminate\Support\ServiceProvider;

class Provider extends ServiceProvider
{
    public function boot ()
    {
        foreach ($this->models() as $model) {
            $model::observe($this->observer());
        }
    }

    private function observer (): string
    {
        return $this->app->make('config')->get('blame.observer');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model[]
     */
    private function models (): array
    {
        return $this->app->make('config')->get('blame.models');
    }
}
