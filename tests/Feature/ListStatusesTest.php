<?php

namespace Tests\Feature;

use App\Models\Status;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ListStatusesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_get_all_status()
    {
        $this->withExceptionHandling();

        $user = factory(User::class)->create();
        $this->actingAs($user);


        $status1 = factory(Status::class)->create([
            'user_id' => $user->id,
            'created_at' => now()->subDays(4)
        ]);

        $status2 = factory(Status::class)->create([
            'user_id' => $user->id,
            'created_at' => now()->subDays(3)
        ]);

        $status3 = factory(Status::class)->create([
            'user_id' => $user->id,
            'created_at' => now()->subDays(2)
        ]);

        $status4 = factory(Status::class)->create([
            'user_id' => $user->id,
            'created_at' => now()->subDays(1)
        ]);



        $response = $this->get('statuses');

        $response->assertSuccessful();



        $response->assertJson([
            'meta' => ['total' => 4]
        ]);

        $response->assertJsonStructure([
            'data','links' => ['first','last',]
        ]);
    }
}
