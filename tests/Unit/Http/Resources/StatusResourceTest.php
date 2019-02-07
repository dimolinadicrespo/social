<?php

namespace Tests\Unit\Http\Resources;

use App\User;
use Tests\TestCase;
use App\Models\Status;
use App\Models\Comment;
use App\Http\Resources\StatusResource;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StatusResourceTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function  a_status_resource_must_have_the_necesary_fields()
    {
        $status = factory(Status::class)->create();
        $user = factory(User::class)->create();

        $comments = factory(Comment::class,3)->create([
            'user_id'   => $user->id,
            'status_id' => $status->id
        ]);

        $statusResource = StatusResource::make($status)->resolve();

        $this->assertEquals($status->id, $statusResource['id']);
        $this->assertEquals($status->body, $statusResource['body']);
        $this->assertEquals($status->user->name, $statusResource['user_name']);
        $this->assertEquals('https://i0.wp.com/aprendible.com/images/default-avatar.jpg?ssl=1', $statusResource['user_avatar']);
        $this->assertEquals($status->created_at->diffForHumans(), $statusResource['ago']);
        $this->assertEquals(false, $statusResource['is_liked']);
        $this->assertEquals(0, $statusResource['count_likes']);

        $this->assertEquals(3,
            $statusResource['comments']->count()
        );

        $this->assertInstanceOf('App\Models\Comment',
            $statusResource['comments']->shift()->resource
        );
        $this->assertInstanceOf('App\Models\Comment',
            $statusResource['comments']->shift()->resource
        );
        $this->assertInstanceOf('App\Models\Comment',
            $statusResource['comments']->shift()->resource
        );
    }
}
