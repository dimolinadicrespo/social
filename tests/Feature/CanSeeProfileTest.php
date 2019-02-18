<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CanSeeProfileTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function authenticated_user_can_see_user_profile()
    {
        factory(User::class)->create(['name' => 'Diego']);
        $this->get('@Diego')->assertSee('Diego');
    }
}
