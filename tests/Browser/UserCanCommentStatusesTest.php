<?php

namespace Tests\Browser;

use App\Models\Comment;
use App\Models\Status;
use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserCanCommentStatusesTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test
     * @throws \Throwable
     */
    public function authenticated_user_can_comment_statuses()
    {
        $user = factory(User::class)->create();
        $status = factory(Status::class)->create();

        $this->browse(function (Browser $browser) use($user,$status) {
            $browser->loginAs($user)
                ->visit('/')
                ->waitForText($status->body)
                ->assertSee($status->body)
                ->type('comment-area','Mi primer status')
                ->press('@comment-btn')
                ->waitForText('Mi primer status')
                ->assertSee('Mi primer status');
        });
    }

    /** @test
     * @throws \Throwable
     */
    function user_can_see_all_comments_of_status()
    {
        $status = factory(Status::class)->create();
        $comments = factory(Comment::class,3)->create([
            'status_id' => $status->id
        ]);

        $this->browse(function (Browser $browser) use($status,$comments) {
            $browser->visit('/')
                ->waitForText($status->body);

            foreach ($comments as $comment) {
                $browser
                    ->assertSee($comment->body)
                    ->assertSee($comment->user->name);

            }

        });

    }
}
