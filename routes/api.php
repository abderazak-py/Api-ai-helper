<?php

use App\Http\Controllers\Api\V1\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/posts', function () {
    return ['id' => '1', 'content' => 'this is my first post'];
});

Route::prefix('v1')->group(function () {Route::apiResource('posts', PostController::class);
    }
);
