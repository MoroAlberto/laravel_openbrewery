<?php

namespace Tests\Feature\Controllers;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
    }

    /*public function test_register()
    {
        $response = $this->postJson('/api/auth/register', [
            'username' => 'Test User',
            'password' => 'password',
        ]);

        $response->assertStatus(201);
        $response->assertJsonStructure(['id', 'username']);
        $this->assertDatabaseHas('users', ['username' => 'Test User']);
    }*/

    public function test_login()
    {
        User::create([
            'username' => 'Test User',
            'password' => bcrypt('password'),
        ]);

        $response = $this->postJson('/api/auth/login', [
            'username' => 'Test User',
            'password' => 'password',
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['access_token', 'token_type', 'expires_in']);
    }

    public function test_login_fails()
    {
        User::create([
            'username' => 'Test User',
            'password' => bcrypt('password'),
        ]);

        $response = $this->postJson('/api/auth/login', [
            'username' => 'Test User',
            'password' => 'wrong_password',
        ]);

        $response->assertStatus(401);
        $response->assertJson(['error' => 'Unauthorized']);
    }

    public function test_me()
    {
        $user = User::create([
            'username' => 'Test User',
            'password' => bcrypt('password'),
        ]);

        $token = auth()->login($user);

        $response = $this->PostJson('/api/auth/me', [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(200);
        $response->assertJson(['username' => 'Test User']);
    }

    public function test_logout()
    {
        $user = User::create([
            'username' => 'Test User',
            'password' => bcrypt('password'),
        ]);

        $token = auth()->login($user);

        $response = $this->postJson('/api/auth/logout', [], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'Successfully logged out']);
    }

    public function test_refresh_token()
    {
        $user = User::create([
            'username' => 'Test User',
            'password' => bcrypt('password'),
        ]);

        $token = auth()->login($user);

        $response = $this->postJson('/api/auth/refresh', [], [
            'Authorization' => 'Bearer ' . $token,
        ]);

        $response->assertStatus(200);
        $response->assertJsonStructure(['access_token', 'token_type', 'expires_in']);
    }
}
