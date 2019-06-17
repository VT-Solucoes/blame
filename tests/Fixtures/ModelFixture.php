<?php

namespace Dbt\Tests\Fixtures;

use Dbt\Blame\BlameRelations;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * @property mixed created_by
 * @property mixed updated_by
 * @property mixed name
 * @property mixed deleted_by
 * @property \Dbt\Tests\Fixtures\UserFixture createdBy
 */
class ModelFixture extends Model
{
    use SoftDeletes, BlameRelations;

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
