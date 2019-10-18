<?php

namespace Dbt\Blame;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 * @mixin \Dbt\Blame\BlameInterface
 */
trait BlameTrait
{
    public function getCreatedBy (): Model
    {
        return $this->createdBy;
    }

    public function getUpdatedBy (): Model
    {
        return $this->updatedBy;
    }

    public function getDeletedBy (): ?Model
    {
        return $this->deletedBy;
    }

    public function createdBy (): BelongsTo
    {
        return $this->belongsTo(
            config('blame.user.model'),
            config('blame.columns.creating'),
            config('blame.user.primary_key')
        );
    }

    public function updatedBy (): BelongsTo
    {
        return $this->belongsTo(
            config('blame.user.model'),
            config('blame.columns.updating'),
            config('blame.user.primary_key')
        );
    }

    public function deletedBy (): BelongsTo
    {
        return $this->belongsTo(
            config('blame.user.model'),
            config('blame.columns.deleting'),
            config('blame.user.primary_key')
        );
    }
}
