<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testLoginTest()
    {
        $user = User::create(
            [
                'name' => 'Test User',
                'email' => 'test@test.ru',
                'password' => bcrypt('password')
            ]
        );

        $response = $this->actingAs($user, 'api')
            ->json('POST', '/api/auth/login',[
                "email" => $user->email,
                "password" => "password"
            ]);

        $response->assertStatus(200);

    }

    public function testRegisterTest()
    {
        $response = $this
            ->json('POST', '/api/auth/register',[
                "email" => "test@test.com",
                "password" => "password",
                "name" => "test user"
            ]);

        $response->assertStatus(200);

    }

    public function testTest()
    {

        $response = $this->get('api/test');
        $response->assertStatus(200);

    }
}
