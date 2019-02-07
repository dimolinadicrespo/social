<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use App\User;
use Laravel\Dusk\Browser;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;
    /**
     * A Dusk test example.
     *
     * @test void
     * @throws \Throwable
     */
    public function registered_user_can_login()
    {
        factory(User::class)->create([
            'email' => 'diego@diego.es'
        ]);
        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                    ->type('email' , 'diego@diego.es')
                    ->type('password','secret')
                    ->press('#login-btn')
                    ->assertAuthenticated();
        });
    }
}
