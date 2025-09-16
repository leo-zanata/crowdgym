<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\LocationService;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     *
     *
     * @param string $state
     * @param LocationService $locationService
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCitiesByState($state, LocationService $locationService)
    {
        $cities = $locationService->getCitiesByState($state);

        if (empty($cities)) {
            return response()->json(['error' => 'State not found.'], 404);
        }

        return response()->json($cities)->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    }
}