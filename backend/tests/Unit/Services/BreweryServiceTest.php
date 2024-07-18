<?php

namespace Tests\Unit\Services;

use App\Services\BreweryService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class BreweryServiceTest extends TestCase
{
    use RefreshDatabase;

    protected BreweryService $breweryService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->breweryService = new BreweryService();
    }

    protected function mockHttpResponses(array $responses): void
    {
        Http::fake([
            '*' => Http::response($responses),
        ]);
    }

    public function test_getBreweries()
    {
        $mockResponse = [
            [
                'id' => '5128df48-79fc-4f0f-8b52-d06be54d0cec',
                'name' => '(405) Brewing Co',
                'brewery_type' => 'micro',
                'address_1' => '1716 Topeka St',
                'address_2' => null,
                'address_3' => null,
                'city' => 'Norman',
                'state_province' => 'Oklahoma',
                'postal_code' => '73069-8224',
                'country' => 'United States',
                'longitude' => '-97.46818222',
                'latitude' => '35.25738891',
                'phone' => '4058160490',
                'website_url' => 'http://www.405brewing.com',
                'state' => 'Oklahoma',
                'street' => '1716 Topeka St',
            ],
        ];

        $this->mockHttpResponses($mockResponse);

        $page = 1;
        $perPage = 1;
        $breweries = $this->breweryService->getBreweries($page, $perPage);

        $this->assertIsArray($breweries);
        $this->assertCount(1, $breweries);
        $this->assertEquals('(405) Brewing Co', $breweries[0]['name']);
    }
}
