<?php

namespace Tests\Feature\Requests;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginRequestTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_without_username_password()
    {
        $response = $this->postJson('/api/auth/login', [
            'username' => '',
            'password' => ''
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['username', 'password']);
    }

    public function test_login_without_username()
    {
        $response = $this->postJson('/api/auth/login', [
            'username' => '',
            'password' => 'root'
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['username']);
    }

    public function test_login_without_password()
    {
        $response = $this->postJson('/api/auth/login', [
            'username' => 'root',
            'password' => ''
        ]);
        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['password']);
    }
}
