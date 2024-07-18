<?php

namespace App\Interfaces;

interface BreweryServiceInterface
{
    public function getBreweries($page = 1, $perPage = 50);
}
