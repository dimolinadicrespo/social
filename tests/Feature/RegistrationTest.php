<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    function  user_can_register()
    {
        $userData = [
            'name'                   => 'Diego',
            'first_name'             => 'Diego',
            'last_name'              => 'Molina',
            'email'                  => 'diego@diego.es',
            'password'               => 'secret',
            'password_confirmation'  => 'secret',
        ];

        $response = $this->post(route('register'),$userData);

        $response->assertRedirect('/');

        $this->assertDatabaseHas('users',[
                'name'                   => 'Diego',
                'first_name'             => 'Diego',
                'last_name'              => 'Molina',
                'email'                  => 'diego@diego.es',
            ]
        );

        $this->assertTrue(
            Hash::check('secret', User::first()->password),
            'The password must be hashed'
        );
    }
}
