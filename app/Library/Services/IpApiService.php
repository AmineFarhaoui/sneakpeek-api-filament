<?php

namespace App\Library\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class IpApiService
{
    /**
     * Get the location details from the IP address.
     */
    public function getLocationDetails(string $ipAddress): Collection
    {
        $response = Cache::remember("ip_adress:$ipAddress", 60 * 60 * 365, function () use ($ipAddress) {
            return Http::get(
                'http://ip-api.com/json/'.$ipAddress,
                [
                    'fields' => 'country,city,timezone',
                ],
            );
        });

        if ($response->failed()) {
            return collect();
        }

        return collect($response->json());
    }
}
