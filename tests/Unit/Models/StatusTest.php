<?php

namespace Tests\Unit\Models;

use App\User;
use Tests\TestCase;
use App\Models\Status;
use App\Models\Comment;
use App\Traits\HasLikes;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StatusTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function a_status_belongs_to_a_user()
    {
        $status = factory(Status::class)->create();
        $this->assertInstanceOf(User::class,$status->user);
    }

    /** @test */
    public function a_status_has_many_comments()
    {
        $user = factory(User::class)->create();
        $status = factory(Status::class)->create();

        factory(Comment::class)->create([
            'status_id' => $status->id,
            'user_id'   => $user->id
        ]);

        $this->assertInstanceOf(Comment::class, $status->comments->first());
    }

    /** @test */
    public function a_status_model_must_be_use_hasliketrait()
    {
        $this->assertClassHasTrait(HasLikes::class,Status::class);
    }


}
