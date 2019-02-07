<?php

namespace Tests\Unit\Traits;

use App\Traits\HasLikes;
use App\User;
use Tests\TestCase;
use App\Models\Like;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Database\Eloquent\Model as Model;

class HasLikeTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function a_model_morph_many_likes()
    {
        $model = new MyModelWithLikes(['id' => 1]);

        factory(Like::class)->create([
            'likeable_id'   => $model->id,
            'likeable_type' => get_class($model)
        ]);

        $this->assertInstanceOf(Like::class, $model->likes->first());
    }

    /** @test */
    public function a_model_can_be_liked()
    {
        $user    = factory(User::class)->create();
        $model = new MyModelWithLikes(['id' => 1]);

        $this->actingAs($user);

        $model->like();

        $this->assertCount(1,$model->likes);
    }

    /** @test */
    public function a_model_can_be_unliked()
    {
        $user    = factory(User::class)->create();
        $model = new MyModelWithLikes(['id' => 1]);

        $this->actingAs($user);
        $model->like();

        $this->assertEquals(1,$model->likes()->count());

        $model->unlike();

        $this->assertEquals(0,$model->likes()->count());
    }

    /** @test */
    public function a_model_can_be_like_once()
    {
        $user = factory(User::class)->create();
        $model = new MyModelWithLikes(['id' => 1]);;

        $this->actingAs($user);

        $model->like();

        $this->assertEquals(1,$model->likes->count());

        $model->like();

        $this->assertEquals(1,$model->likes->count());
    }

    /** @test */
    public function a_model_has_been_like()
    {
        $model = new MyModelWithLikes(['id' => 1]);;

        $this->actingAs(factory(User::class)->create());

        $this->assertEquals(false,$model->isLiked());

        $model->like();

        $this->assertEquals(true,$model->isLiked());
    }
    /** @test */
    public function a_status_has_been_unlike()
    {
        $model = new MyModelWithLikes(['id' => 1]);;

        $this->actingAs(factory(User::class)->create());

        $this->assertEquals(false,$model->isLiked());

        $model->like();

        $this->assertEquals(true,$model->isLiked());

        $model->unlike();

        $this->assertEquals(false,$model->isLiked());
    }
    /** @test */
    public function a_status_knows_how_many_likes_has()
    {
        $model = new MyModelWithLikes(['id' => 1]);;

        factory(Like::class,1)->create([
            'likeable_id'   => $model->id,
            'likeable_type' => get_class($model)
        ]);

        $this->assertEquals(1,$model->countLikes());

        factory(Like::class,2)->create([
            'likeable_id'   => $model->id,
            'likeable_type' => get_class($model)
        ]);

        $this->assertEquals(3,$model->countLikes());
    }
}

class MyModelWithLikes extends Model
{
    use HasLikes;
    protected $fillable = ['id'];
}
