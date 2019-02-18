<?php

namespace Tests\Unit\Models;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function method_link_return_url_of_profile_user()
    {
        $user = factory(User::class)->create([
            'name' => 'Dieguísimo'
        ]);
        $urlProfile = route('users.show',$user);
        $this->assertEquals($urlProfile,$user->link());
    }

    /** @test */
    public function the_key_of_the_route_must_be_the_name()
    {
        $user = factory(User::class)->make();

        $this->assertEquals('name',$user->getRouteKeyName());
    }

    /** @test */
    public function the_has_an_avatar()
    {
        $user = factory(User::class)->make();

        $this->assertEquals('https://i0.wp.com/aprendible.com/images/default-avatar.jpg?ssl=1',$user->avatar());
    }
}
