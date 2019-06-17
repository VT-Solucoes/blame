<?php

namespace Dbt\Blame;

use Closure;
use Illuminate\Database\Eloquent\Model;

class WithoutEvents
{
    public static function run (Closure $closure): void
    {
        $dispatcher = Model::getEventDispatcher();

        Model::unsetEventDispatcher();

        $closure();

        Model::setEventDispatcher($dispatcher);
    }
}
