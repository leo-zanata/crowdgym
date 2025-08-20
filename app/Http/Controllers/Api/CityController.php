<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class CityController extends Controller
{
    public function getCitiesByState($state)
    {
        $path = storage_path('app/data/states_and_cities.json');
        if (!File::exists($path)) {
            return response()->json(['error' => 'Data file not found.'], 404);
        }

        $json = File::get($path);

        $data = json_decode($json, true);

        $states = $data['estados'];

        foreach ($states as $item) {
            if ($item['sigla'] === $state) {
                return response()->json($item['cidades']);
            }
        }
        return response()->json(['error' => 'State not found.'], 404);
    }
}