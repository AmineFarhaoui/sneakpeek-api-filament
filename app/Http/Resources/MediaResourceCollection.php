<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class MediaResourceCollection extends ResourceCollection
{
    /**
     * Force the resource to use its own array strucutre instead of possible
     * exceptions.
     *
     * @var bool
     */
    public $forceMediaResource = false;

    /**
     * Create a new resource instance.
     */
    public function __construct($resource, bool $forceMediaResource = false)
    {
        parent::__construct($resource);

        $this->forceMediaResource = $forceMediaResource;
    }

    /**
     * Transform the resource collection into an array.
     */
    public function toArray(?Request $request): array
    {
        return $this->resource->map(function (MediaResource $resource) {
            $resource->forceMediaResource = $this->forceMediaResource;

            return $resource;
        })->toArray();
    }
}
