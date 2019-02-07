<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Status;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateCommentTest extends TestCase
{
    use RefreshDatabase;
    /** @test */

    function an_authenticated_user_can_comment_statuses()
    {
        $status = factory(Status::class)->create();
        $user   = factory(User::class)->create();
        $comment = ['body' => 'Mi primer comentario'];

        $response = $this->actingAs($user)->postJson(route('statuses.comments.store',$status), $comment);

        $response->assertJson([
            'data' => [
                'body' => $comment['body'],
                'user_name' => $user->name,
                'status_id' => $status->id,
            ]
        ]);

        $this->assertDatabaseHas('comments',[
            'user_id' => $user->id,
            'status_id' => $status->id,
            'body' => $comment['body']
        ]);
    }


    /** @test */
    function a_guest_cant_create_comments()
    {
        $status = factory(Status::class)->create();
        $comment = ['body' => 'Mi primer comentario'];

        $response = $this->postJson(route('statuses.comments.store',$status), $comment);

        // Código 401
        // Symphony/http-foundation/response
        $response->assertStatus(401);

    }

}
