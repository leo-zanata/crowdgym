<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;

class LocationService
{
    /**
     *
     * * @return array
     */
    public function getStates(): array
    {
        return Cache::rememberForever('location.states', function () {
            
            $path = database_path('data/states_and_cities.json');

            if (!File::exists($path)) {
                return [];
            }

            $json = File::get($path);
            $data = json_decode($json, true);
            
            return collect($data['estados'])->pluck('nome', 'sigla')->all();
        });
    }

    /**
     *
     * * @param string
     * @return array
     */
    public function getCitiesByState(string $stateAbbr): array
    {
        $key = 'location.cities.' . strtoupper($stateAbbr);

        return Cache::rememberForever($key, function () use ($stateAbbr) {
            
            $path = database_path('data/states_and_cities.json');

            if (!File::exists($path)) {
                return [];
            }

            $json = File::get($path);
            $data = json_decode($json, true);

            $selectedState = collect($data['estados'])->firstWhere('sigla', strtoupper($stateAbbr));

            return $selectedState['cidades'] ?? [];
        });
    }
}