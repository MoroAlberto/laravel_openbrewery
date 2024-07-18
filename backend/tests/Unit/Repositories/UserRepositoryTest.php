<?php

namespace Tests\Unit\Repositories;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRepositoryTest extends TestCase
{
    use RefreshDatabase;

    protected UserRepositoryInterface $userRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepository = new UserRepository();
    }

    public function test_create_user()
    {
        $data = [
            'username' => 'Test User',
            'password' => 'password'
        ];

        $user = $this->userRepository->create($data);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('Test User', $user->username);
    }

    public function test_find_by_username()
    {
        $user = User::factory()->create(['username' => 'Test User']);

        $foundUser = $this->userRepository->findByUsername('Test User');

        $this->assertInstanceOf(User::class, $foundUser);
        $this->assertEquals($user->id, $foundUser->id);
    }
}
