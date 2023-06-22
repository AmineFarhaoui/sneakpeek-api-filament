<?php

namespace App\Http\Resources;

use App\Library\Enumerations\Role;
use Illuminate\Http\Request;

class UserResource extends JsonResource
{
    /**
     * Transforms the resource into an array.
     */
    public function toArray(?Request $request): array
    {
        $data = [
            'id' => $this->resource->id,
            'first_name' => $this->resource->first_name,
            'last_name' => $this->resource->last_name,
            'full_name' => $this->resource->full_name,
            'profile_picture' => $this->getMedia('profile_picture'),
        ];

        if ($this->userCanViewSensitiveData()) {
            $this->addSensitiveData($data);
        }

        return $data;
    }

    /**
     * Determines if the current user can see sensitive data.
     */
    public function userCanViewSensitiveData(): bool
    {
        return current_user()->hasRole(Role::ADMIN)
            || current_user()->is($this->resource);
    }

    /**
     * Adds data that should only be visible to the users that should see it.
     */
    public function addSensitiveData(array &$data): void
    {
        $data = array_merge($data, [
            'email' => $this->resource->email,
            'roles' => resource($this->whenLoaded('roles')),
        ]);
    }
}
