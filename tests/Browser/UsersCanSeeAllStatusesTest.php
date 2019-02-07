<?php

namespace Tests\Browser;

use App\Models\Status;
use App\User;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UsersCanSeeAllStatusesTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * A Dusk test example.
     *
     * @test
     * @throws \Throwable
     */
    public function user_can_see_all_status_on_home_page()
    {
        $statuses = factory(Status::class,3)->create();
        $user     = factory(User::class)->create();

        $this->browse(function (Browser $browser) use ($statuses,$user){


            $browser->loginAs($user)
                    ->visit('/')
                    ->waitForText($statuses->first()->body);



            foreach ($statuses as $status)
            {
                $browser->assertSee($status->body)
                    ->assertSee($status->user->name)
                    ->assertSee($status->created_at->diffForHumans());

            }

        });
    }
}
