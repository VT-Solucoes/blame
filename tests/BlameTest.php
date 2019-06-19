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
    public function creating_when_default_is_set ()
    {
        $model = ModelFixture::make();

        $this->assertSame($this->getDefaultId(), $model->created_by);
    }

    /** @test */
    public function creating_when_default_is_not_set ()
    {
        $this->unsetDefaultId();
        $model = ModelFixture::make();

        $this->assertNull($model->created_by);
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
    public function updating_when_default_is_set ()
    {
        $model = ModelFixture::make();

        $model->name = Str::random(8);
        $model->save();

        $this->assertSame($this->getDefaultId(), $model->updated_by);
    }

    /** @test */
    public function updating_when_default_is_not_set ()
    {
        $this->unsetDefaultId();
        $model = ModelFixture::make();

        $model->name = Str::random(8);
        $model->save();

        $this->assertNull($model->updated_by);
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

    /** @test */
    public function deleting_when_default_is_set ()
    {
        $model = ModelFixture::make();

        $model->delete();

        $this->assertSame($this->getDefaultId(), $model->deleted_by);
    }

    /** @test */
    public function deleting_when_default_is_not_set ()
    {
        $this->unsetDefaultId();

        $model = ModelFixture::make();
        $model->delete();

        $this->assertNull($model->deleted_by);
    }

    /** @test */
    public function manually_set_values_arent_overwritten ()
    {
        $id = 9999999;
        $user = $this->beUser();

        $model = ModelFixture::make(['created_by' => $id]);

        $this->assertSame($id, $model->created_by);
        $this->assertNotSame($user->id, $model->created_by);
    }

    /** @test */
    public function relations ()
    {
        $user1 = $this->beUser();

        $model = ModelFixture::make();

        $user2 = $this->beAnotherUser();

        $model->name = Str::random(12);
        $model->save();

        $user3 = $this->beAnotherUser();

        $model->delete();

        $this->assertEquals($user1->name, $model->createdBy->name);
        $this->assertEquals($user2->name, $model->updatedBy->name);
        $this->assertEquals($user3->name, $model->deletedBy->name);
    }
}
