<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_example()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->withPersonalTeam()->create();
        $this->actingAs($user);

        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
