<?php

namespace Tests\Feature\Requests;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BreweryRequestTest extends TestCase
{
    use RefreshDatabase;

    protected string $token;

    public function setUp(): void
    {
        parent::setUp();
        $user = User::create([
            'username' => 'root',
            'password' => bcrypt('password'),
        ]);
        $this->token = auth()->login($user);
    }

    /**
     * Test valid request parameters.
     *
     * @return void
     */
    public function test_valid_request_parameters()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/breweries', ['page' => 1, 'per_page' => 50]);

        $response->assertStatus(200);
    }

    /**
     * Test invalid page parameter.
     *
     * @return void
     */
    public function test_invalid_page_parameter()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/breweries', ['page' => 'invalid', 'per_page' => 50]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('page');
    }

    /**
     * Test invalid per_page parameter.
     *
     * @return void
     */
    public function test_invalid_per_page_parameter()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/breweries', ['page' => 1, 'per_page' => 'invalid']);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors('per_page');
    }

    /**
     * Test missing page parameter (should use default).
     *
     * @return void
     */
    public function test_missing_page_parameter()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/breweries', ['per_page' => 10]);
        $response->assertStatus(200);
    }

    /**
     * Test missing per_page parameter (should use default).
     *
     * @return void
     */
    public function test_missing_per_page_parameter()
    {
        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$this->token,
        ])->json('GET', '/api/breweries', ['page' => 1]);

        $response->assertStatus(200);
    }
}
