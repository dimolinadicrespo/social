<?php

namespace Tests\Unit\Http\Resources;

use Tests\TestCase;
use App\Models\Comment;
use App\Http\Resources\UserResource;
use App\Http\Resources\CommentResource;
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

        $this->assertInstanceOf(
            UserResource::class,
            $commentResource['user']
        );

        $this->assertEquals($comment->status->id, $commentResource['status_id']);
        $this->assertEquals(0, $commentResource['count_likes']);
        $this->assertEquals(false, $commentResource['is_liked']);
    }
}
