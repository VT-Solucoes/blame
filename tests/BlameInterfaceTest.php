<?php

namespace Dbt\Tests;

use Dbt\Tests\Fixtures\ModelFixture;
use Illuminate\Support\Str;

class BlameInterfaceTest extends TestCase
{
    /** @test */
    public function getting_the_relations ()
    {
        $creator = $this->beUser();
        $model = ModelFixture::make();

        $this->assertTrue($creator->is($model->getCreatedBy()));

        $updater = $this->beAnotherUser();

        $model->name = Str::random(32);
        $model->save();

        $this->assertTrue($updater->is($model->getUpdatedBy()));

        $deleter = $this->beAnotherUser();

        $model->delete();

        $this->assertTrue($deleter->is($model->getDeletedBy()));
    }
}
