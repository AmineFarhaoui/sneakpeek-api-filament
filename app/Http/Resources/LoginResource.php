<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;

class LoginResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(?Request $request): array
    {
        return [
            'api_token' => $this->resource['api_token'],
            'user' => resource($this->resource['user']),
        ];
    }
}
