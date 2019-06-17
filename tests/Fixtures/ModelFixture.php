<?php

namespace Dbt\Tests\Fixtures;

use Dbt\Blame\Relations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * @property mixed created_by
 * @property mixed updated_by
 * @property mixed name
 * @property mixed deleted_by
 * @property \Dbt\Tests\Fixtures\UserFixture createdBy
 * @property \Dbt\Tests\Fixtures\UserFixture updatedBy
 * @property \Dbt\Tests\Fixtures\UserFixture deletedBy
 */
class ModelFixture extends Model
{
    use SoftDeletes, Relations;

    protected $table = 'blame';
    protected $guarded = [];

    public static function make (array $with = []): self
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return self::query()->create(
            array_merge(
                ['name' => Str::random(16)],
                $with
            )
        );
    }
}
