<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/blog/posts', [\App\Http\Controllers\Api\Blog\PostController::class, 'index']);
Route::get('/blog/posts/{id}', [\App\Http\Controllers\Api\Blog\PostController::class, 'show']);
Route::post('/blog/posts/create', [\App\Http\Controllers\Api\Blog\PostController::class, 'store']);
Route::put('/blog/posts/edit/{id}', [\App\Http\Controllers\Api\Blog\PostController::class, 'update']);
Route::delete('/blog/posts/delete/{id}', [\App\Http\Controllers\Api\Blog\PostController::class, 'destroy']);

Route::get('/blog/categories/forCombobox', [\App\Http\Controllers\Api\Blog\CategoryGetController::class, 'index']);
Route::get('/blog/categories', [\App\Http\Controllers\Api\Blog\CategoryController::class, 'index']);
Route::get('/blog/categories/{id}', [\App\Http\Controllers\Api\Blog\CategoryController::class, 'show']);
Route::post('/blog/categories/create', [\App\Http\Controllers\Api\Blog\CategoryController::class, 'store']);
Route::put('/blog/categories/edit/{id}', [\App\Http\Controllers\Api\Blog\CategoryController::class, 'update']);
Route::delete('/blog/categories/delete/{id}', [\App\Http\Controllers\Api\Blog\CategoryController::class, 'destroy']);

