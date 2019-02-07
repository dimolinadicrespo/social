<?php

namespace Tests\Browser;

use App\User;
use App\Models\Status;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserCanLikeStatusTest extends DuskTestCase
{
    use DatabaseMigrations;
    /** @test
     * @throws \Throwable
     */
    public function user_can_like_statuses()
    {
        $user = factory(User::class)->create();
        $status = factory(Status::class)->create();

        $this->browse(function (Browser $browser)  use ($user,$status) {
            $browser->loginAs($user)
                    ->visit('/')
                    ->waitForText($status->body)
                    ->assertSeeIn('@status-likes-count',0)
                    ->press('@status-like-btn')
                    ->waitForText('Te gusta')
                    ->assertSee('Te gusta')
                    ->assertSeeIn('@status-likes-count',1)
                    ->press('@status-like-btn')
                    ->waitForText('Me gusta');
        });
    }

    /** @test
     * @throws \Throwable
     */
    public function guest_user_cant_like_statuses()
    {
        $status = factory(Status::class)->create(['body'=>'asdfasf']);

        $this->browse(function (Browser $browser)  use ($status) {
            $browser->visit('/')
                ->waitForText($status->body)
                ->press('@status-like-btn')
                ->assertPathIs('/login');
        });
    }
}
