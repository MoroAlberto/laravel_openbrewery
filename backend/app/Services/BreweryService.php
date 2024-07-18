<?php

namespace App\Services;

use App\Interfaces\BreweryServiceInterface;
use Illuminate\Support\Facades\Http;

class BreweryService implements BreweryServiceInterface
{
    protected string $apiUrl;

    public function __construct()
    {
        $this->apiUrl = config('services.brewery.url');
    }

    public function getBreweries($page = 1, $perPage = 10)
    {
        //\Log::info("Fetching breweries with page: {$page}, per_page: {$perPage}");

        $response = Http::get("{$this->apiUrl}/breweries", [
            'query' => [
                'page' => $page,
                'per_page' => $perPage,
            ],
        ]);

        //\Log::info("Response: " . $response->getBody()->getContents());

        return json_decode($response->getBody()->getContents(), true);
    }
}
