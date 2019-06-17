<?php

namespace Dbt\Tests;

use Dbt\Tests\Fixtures\ModelFixture;
use Illuminate\Support\Str;

class BlameTest extends TestCase
{
    /** @test */
    public function creating ()
    {
        $user = $this->beUser();

        $model = ModelFixture::make();

        $this->assertSame($user->id, $model->created_by);
    }

    /** @test */
    public function updating ()
    {
        $user1 = $this->beUser();

        $model = ModelFixture::make();

        $user2 = $this->beAnotherUser();

        $model->name = Str::random(12);
        $model->save();

        $this->assertSame($user1->id, $model->created_by);
        $this->assertSame($user2->id, $model->updated_by);
    }

    /** @test */
    public function deleting ()
    {
        $user1 = $this->beUser();

        $model = ModelFixture::make();

        $user2 = $this->beAnotherUser();

        $model->name = Str::random(12);
        $model->save();

        $user3 = $this->beAnotherUser();

        $model->delete();

        $this->assertSame($user1->id, $model->created_by);
        $this->assertSame($user2->id, $model->updated_by);
        $this->assertSame($user3->id, $model->deleted_by);
    }
}
