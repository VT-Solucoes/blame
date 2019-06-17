<?php

namespace Dbt\Tests\Fixtures;

use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Str;

/**
 * @property int id
 */
class UserFixture extends User
{
    protected $table = 'user';
    protected $guarded = [];

    public static function make (): self
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return self::query()->create([
            'id' => rand(1, 9999),
            'name' => Str::random(16),
            'email' => Str::random(16),
            'password' => Str::random(32),
        ]);
    }
}
