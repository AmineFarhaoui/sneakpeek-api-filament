<?php

namespace App\Http\Middleware\ConvertCase;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ConvertRequestToSnakeCase
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): ?Response
    {
        $inputs = [$request->query];

        if ($request->isJson()) {
            $inputs[] = $request->json();
        } else {
            $inputs[] = $request->request;
        }

        foreach ($inputs as $input) {
            $input->replace(array_keys_convert_case($input->all(), 'snake'));
        }

        return $next($request);
    }
}
