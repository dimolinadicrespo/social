<?php

namespace Tests\Unit\Models;

use App\User;
use Tests\TestCase;
use App\Traits\HasLikes;
use App\Models\Comment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic test example.
     *
     * @test void
     */
    public function a_comment_belong_to_user()
    {
        $user    = factory(User::class)->create();
        $comment = factory(Comment::class)->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class,$comment->user);
    }
    /** @test */
    public function a_comment_model_must_be_use_hasliketrait()
    {
        $this->assertClassHasTrait(HasLikes::class,Comment::class);
    }
}
