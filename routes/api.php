<?php

use App\Http\Controllers\Api\v1\Admin\UserController;
use App\Http\Controllers\ArticleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('users', UserController::class);
Route::apiResource('articles', ArticleController::class)->only(['index']);
