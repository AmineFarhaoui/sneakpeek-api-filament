<?php

use App\Http\Controllers\Users\UserController;
use App\Http\Requests\Users\UpdateRequest;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')
    ->group(function () {
        Route::apiResource('users', UserController::class, [
            'requests' => [
                'update' => UpdateRequest::class,
            ],
            'model' => User::class,
        ])
            ->only(['show', 'update']);
    });
