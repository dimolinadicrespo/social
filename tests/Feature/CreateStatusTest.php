<?php

namespace Tests\Feature;

use App\Http\Middleware\VerifyCsrfToken;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateStatusTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    public function an_guest_user_cant_create_status()
    {
        $response = $this->post(route('statuses.store',['body' => 'My first status']));
        $response->assertSee('login');
    }

    /** @test */
    public function an_authenticated_user_can_create_statuses()
    {
        $this->withoutExceptionHandling();
//        $this->withExceptionHandling();
//        1.Given - > Teniendo un usuarioa utenticado
//        2.When -> Cuando hacemos una petición  post  request a la url status
//        3.Then - > Veo un nuevo estado en la base de datos
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response = $this->post(route('statuses.store'),['body' => 'Mi primer status']);

        $response->assertJson([
            'data' => [
                'body' => 'Mi primer status',
                'user_name' => auth()->user()->name
            ]
        ]);

        $this->assertDatabaseHas('statuses',
            [
                'body' => 'Mi primer status',
                'user_id' => auth()->id()
            ]
        );
    }


    /** @test */
    public function a_status_required_boyd()
    {
        $user = factory(User::class)->create();
        $this->actingAs($user);

        $response = $this->postJson(route('statuses.store'),['body' => '']);

        $response->assertJsonStructure(['message','errors' => ['body']]);
    }


}
