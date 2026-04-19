<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class LocationApiController extends Controller
{
    /**
     * Search areas via Biteship API
     */
    public function search(Request $request)
    {
        $input = $request->input('q');
        
        if (strlen($input) < 3) {
            return response()->json(['areas' => []]);
        }

        // Cache results to prevent hitting API aggressively
        $cacheKey = 'biteship_areas_' . md5($input);
        
        $areas = Cache::remember($cacheKey, 3600, function () use ($input) {
            $response = Http::withHeaders([
                'Authorization' => env('BITESHIP_API_KEY')
            ])->get(env('BITESHIP_BASE_URL') . '/v1/maps/areas', [
                'countries' => 'ID',
                'input' => $input,
                'type' => 'single' // single area string
            ]);

            if ($response->successful()) {
                return $response->json('areas') ?? [];
            }
            
            return [];
        });

        return response()->json(['areas' => $areas]);
    }
}
