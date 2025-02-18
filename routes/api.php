<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DescriptionController;
use App\Http\Controllers\Api\ContactController;

Route::controller(AuthController::class)->group(function () {
  Route::post('register', 'register');
  Route::post('login', 'login');
});

Route::apiResources([
  'banners' => BannerController::class,
  'descriptions' => DescriptionController::class,
  'contacts' => ContactController::class,
], ['only' => ['index', 'show']]);

Route::middleware('auth:sanctum')->group(function () {
  Route::apiResources([
    'banners' => BannerController::class,
    'descriptions' => DescriptionController::class,
    'contacts' => ContactController::class,
  ], ['except' => ['index', 'show']]);

  Route::post('logout', [AuthController::class, 'logout']);
  Route::get('/user', fn(Request $request) => $request->user());
});
