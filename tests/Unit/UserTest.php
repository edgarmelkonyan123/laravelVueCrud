<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use App\User;

class UserTest extends TestCase
{
    use WithoutMiddleware, WithFaker;

    /**
     * Test if we get user data by specified route.
     *
     * @return void
     */
    public function testGetUser()
    {
        $user = User::first();

        $response = $this->get('getUser/'.$user->id);

        $response->assertStatus(200);

        $response->assertJson([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'email_verified_at' => $user->email_verified_at,
            'created_at' => $user->created_at,
            'updated_at' => $user->updated_at
        ]);
    }

    /**
     * Test if new user is created and if the request redirects to correct uri.
     *
     * @return void
     */
    public function testCreateUser()
    {
        $email = $this->faker->email;

        $response = $this->post('user', ['name' => $this->faker->name, 'email' => $email, 'password' => str_random(6)]);

        $this->assertDatabaseHas('users', [
            'email' => $email
        ]);

        $response->assertRedirect('user');

    }
}
