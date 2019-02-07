<?php

namespace Tests\Unit\Http\Resources;

use App\Models\Comment;
use Tests\TestCase;
use App\Models\Status;
use App\Http\Resources\CommentResource;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentResourceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function  a_comment_resource_must_have_the_necesary_fields()
    {
        $comment = factory(Comment::class)->create();

        $commentResource = CommentResource::make($comment)->resolve();


        $this->assertEquals($comment->id, $commentResource['id']);
        $this->assertEquals($comment->body, $commentResource['body']);
        $this->assertEquals($comment->user->name, $commentResource['user_name']);
        $this->assertEquals($comment->status->id, $commentResource['status_id']);
        $this->assertEquals(0, $commentResource['count_likes']);
        $this->assertEquals(false, $commentResource['is_liked']);
        $this->assertEquals('https://i0.wp.com/aprendible.com/images/default-avatar.jpg?ssl=1', $commentResource['user_avatar']);
    }
}
