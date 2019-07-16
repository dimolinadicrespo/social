<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
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

    /** @test */
    function the_name_is_required()
    {
        $userData = $this->userValidData(['name' => null]);
        $this->post(route('register'),$userData)->assertSessionHasErrors(['name']);
    }

    /** @test */
    function the_name_must_be_string()
    {
        $userData = $this->userValidData(['name' => 1234]);
        $this->post(route('register'),$userData)->assertSessionHasErrors(['name']);
    }

    /** @test */
    function the_name_not_be_greater_than_100_characters()
    {
        $userData = $this->userValidData(['name' => str_random(101)]);
        $this->post(route('register'),$userData)->assertSessionHasErrors(['name']);
    }

    /** @test */
    function the_first_name_is_required()
    {
        $userData = $this->userValidData(['first_name' => null]);
        $this->post(route('register'),$userData)->assertSessionHasErrors(['first_name']);
    }

    /** @test */
    function the_first_name_must_be_string()
    {
        $userData = $this->userValidData(['first_name' => 1234]);
        $this->post(route('register'),$userData)->assertSessionHasErrors(['first_name']);
    }

    /** @test */
    function the_first_name_not_be_greater_than_100_characters()
    {
        $userData = $this->userValidData(['first_name' => str_random(101)]);
        $this->post(route('register'),$userData)->assertSessionHasErrors(['first_name']);
    }

    /** @test */
    function the_last_name_is_required()
    {
        $userData = $this->userValidData(['last_name' => null]);
        $this->post(route('register'),$userData)->assertSessionHasErrors(['last_name']);
    }

    /** @test */
    function the_last_name_must_be_string()
    {
        $userData = $this->userValidData(['last_name' => 1234]);
        $this->post(route('register'),$userData)->assertSessionHasErrors(['last_name']);
    }

    /** @test */
    function the_last_name_not_be_greater_than_100_characters()
    {
        $userData = $this->userValidData(['last_name' => str_random(101)]);
        $this->post(route('register'),$userData)->assertSessionHasErrors(['last_name']);
    }

    /** @test */
    function the_email_is_required()
    {
        $userData = $this->userValidData(['email' => null]);
        $this->post(route('register'),$userData)->assertSessionHasErrors(['email']);
    }

    /** @test */
    function the_email_must_be_valid()
    {
        $userData = $this->userValidData(['email' => 'asdf@asdf']);
        $this->post(route('register'),$userData)->assertSessionHasErrors(['email']);
    }

    /** @test */
    function the_email_must_be_unique()
    {
        factory(User::class)->create(['email' => 'diego@diego.es' ]);
        $userData = $this->userValidData(['email' => 'diego@diego.es']);
        $this->post(route('register'),$userData)->assertSessionHasErrors(['email']);
    }

    /** @test */
    function the_password_is_required()
    {
        $userData = $this->userValidData(['password' => null]);
        $this->post(route('register'),$userData)->assertSessionHasErrors(['password']);
    }

    /** @test */
    function the_password_must_be_confirmed()
    {
        $userData = $this->userValidData([
            'password'              => 'asfas',
            'password_confirmation' => null
        ]);
        $this->post(route('register'),$userData)->assertSessionHasErrors(['password']);
    }

    public function userValidData($override = []): array
    {
        return  array_merge(
            [
                'name' => 'Diego',
                'first_name' => 'Diego',
                'last_name' => 'Molina',
                'email' => 'diego@diego.es',
                'password' => 'secret',
                'password_confirmation' => 'secret',
            ],
            $override
        );
    }
}
