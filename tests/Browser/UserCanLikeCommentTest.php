<?php

namespace Tests\Browser;

use App\User;
use Tests\DuskTestCase;
use App\Models\Comment;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserCanLikeCommentTest extends DuskTestCase
{
    use DatabaseMigrations;
    /** @test
     * @throws \Throwable
     */
    public function user_can_like_and_unlike_comment_test()
    {
        $user = factory(User::class)->create();
        $comment = factory(Comment::class)->create();

        $this->browse(function (Browser $browser)  use ($user,$comment) {
            $browser->loginAs($user)
                ->visit('/')
                ->waitForText($comment->body)
                ->assertSeeIn('@comments-likes-count',0)
                ->press('@comment-like-btn')
                ->waitForText('Te gusta')
                ->assertSee('Te gusta')
                ->assertSeeIn('@comments-likes-count',1)
                ->press('@comment-like-btn')
                ->waitForText('Me gusta');
        });
    }
}
