<?php

namespace Dbt\Blame;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin \Illuminate\Database\Eloquent\Model
 */
trait Relations
{
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
