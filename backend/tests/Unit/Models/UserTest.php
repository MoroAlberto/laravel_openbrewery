<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\User;

class UserTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateUser()
    {
        $user = User::create([
            'username' => 'testuser',
            'password' => bcrypt('password')
        ]);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('testuser', $user->username);
    }
}
