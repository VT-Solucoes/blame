<?php

namespace Dbt\Blame;

use Illuminate\Database\Eloquent\Model;

interface BlameInterface
{
    public function getCreatedBy (): Model;
    public function getUpdatedBy (): Model;
    public function getDeletedBy (): ?Model;
}
