<?php

namespace Tests\Browser;

use App\User;
use Faker\Factory;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserCanCreateStatusesTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * A Dusk test example.
     * @test
     * @return void
     * @throws \Throwable
     */
    public function user_can_create_statuses()
    {
        $user = Factory(User::class)->create();

        $this->browse(function (Browser $browser) use ($user) {

            $browser->loginAs($user)
                    ->visit('/')
                    ->type('body','Mi primer status')
                    ->press('#create-status')
                    ->waitForText('Mi primer status')
                    ->assertSee( $user->name)
                    ->assertSee('Mi primer status');
        });
    }
}
