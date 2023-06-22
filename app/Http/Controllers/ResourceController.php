<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use OwowAgency\LaravelResources\Controllers\ResourceController as BaseResourceController;

class ResourceController extends BaseResourceController
{
    /**
     * Returns models instances used for the index action.
     */
    public function indexModel()
    {
        if (method_exists($this->resourceModelClass, 'scopeHttpQuery')) {
            return $this->resourceModelClass::httpQuery()->paginate();
        }

        return $this->resourceModelClass::paginate();
    }

    /**
     * Display a listing of the related resource.
     */
    public function indexRelatable(Request $request, Model $model): JsonResponse
    {
        $relation = ucfirst((new $this->resourceModelClass)->getTable());

        $this->authorize("view$relation", $model);

        $models = $this->indexRelatableModel($request, $model);

        $resources = resource($models);

        return ok($resources);
    }

    /**
     * Returns models instances used for the index related action.
     */
    public function indexRelatableModel(Request $request, Model $model): LengthAwarePaginator
    {
        return $this->resourceModelClass::paginate();
    }

    /**
     * Return scope method name of related model.
     */
    protected function relatableMethodName(Model $model): string
    {
        return Str::of($model->getMorphClass())
            ->singular()
            ->ucfirst()
            ->prepend('of')
            ->toString();
    }
}
