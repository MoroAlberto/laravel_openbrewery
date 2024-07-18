<?php

namespace App\Http\Controllers;

use App\Http\Requests\BreweryRequest;
use App\Services\BreweryService;
use Illuminate\Http\JsonResponse;

class BreweryController extends Controller
{
    public function __construct(protected BreweryService $breweryService)
    {
    }

    public function index(BreweryRequest $request): JsonResponse
    {
        $page = $request->input('page', 1);
        $perPage = $request->input('per_page', 10);

        $breweries = $this->breweryService->getBreweries($page, $perPage);

        return response()->json($breweries);
    }
}
