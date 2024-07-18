<?php

namespace Tests\Unit\Services;

use App\Models\User;
use App\Services\AuthService;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Mockery;
use Tests\TestCase;

class AuthServiceTest extends TestCase
{
    use RefreshDatabase;

    protected AuthService $authService;
    protected UserRepositoryInterface $userRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepository = Mockery::mock(UserRepositoryInterface::class);
        $this->authService = new AuthService($this->userRepository);
    }

    /*public function test_register_user()
    {
        $data = [
            'username' => 'Test User',
            'password' => 'password',
        ];

        $this->userRepository->shouldReceive('create')->once()->andReturn(new User($data));

        $result = $this->authService->register($data);

        $this->assertArrayHasKey('data', $result);
        $this->assertEquals('Test User', $result['data']->username);
    }

    public function test_register_user_validation_fails()
    {
        $data = [
            'username' => '',
            'password' => 'pass'
        ];

        $result = $this->authService->register($data);

        $this->assertArrayHasKey('error', $result);
        $this->assertEquals(400, $result['status']);
    }*/

    public function test_login_user()
    {
        $user = User::factory()->create(['username' => 'Test User', 'password' => Hash::make('password')]);
        $credentials = ['username' => 'Test User', 'password' => 'password'];

        $result = $this->authService->login($credentials);

        $this->assertArrayHasKey('data', $result);
        $this->assertArrayHasKey('access_token', $result['data']);
    }

    public function test_login_user_unauthorized()
    {
        $credentials = ['username' => 'Test User', 'password' => 'wrong_password'];

        $result = $this->authService->login($credentials);

        $this->assertArrayHasKey('error', $result['data']);
        $this->assertEquals(401, $result['status']);
    }
}
