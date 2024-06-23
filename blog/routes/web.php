<?php

use App\Http\Controllers\DiggingDeeperController;
use App\Http\Controllers\RestTestController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::resource('rest', RestTestController::class)->names('restTest');
Route::group(['prefix' => 'digging_deeper'], function () {

    Route::get('collections', [DiggingDeeperController::class, 'collections'])

        ->name('digging_deeper.collections');

        Route::get('process-video', [DiggingDeeperController::class, 'processVideo'])
        ->name('digging_deeper.processVideo');

        Route::get('prepare-catalog',[DiggingDeeperController::class, 'prepareCatalog'])
        ->name('digging_deeper.prepareCatalog');

});
Route::group([ 'namespace' => 'App\Http\Controllers\Blog', 'prefix' => 'blog'], function () {
    Route::resource('posts', PostController::class)->names('blog.posts');
});

//Адмінка
$groupData = [
    'namespace' => 'App\Http\Controllers\Blog\Admin',
    'prefix' => 'admin/blog',
];
Route::group($groupData, function () {
    //BlogCategory
    $methods = ['index','edit','store','update','create',];
    Route::resource('categories', CategoryController::class)
    ->only($methods)
    ->names('blog.admin.categories');

      //BlogPost
      Route::resource('posts', PostController::class)
      ->except(['show'])                               //не робити маршрут для метода show
      ->names('blog.admin.posts');
 });

// Route::get('api/blog/posts', [\App\Http\Controllers\Api\Blog\PostController::class, 'index']);
//Route::get('api/blog/posts/{id}', [\App\Http\Controllers\Api\Blog\PostController::class, 'show']);
////Route::post('api/blog/posts/create', [\routes\Api\Blog\PostController::class, 'store']);
////Route::put('api/blog/posts/edit/{id}', [\routes\Api\Blog\PostController::class, 'update']);
////Route::delete('api/blog/posts/delete/{id}', [\routes\Api\Blog\PostController::class, 'destroy']);
//
// Route::get('api/blog/categories/forCombobox', [\routes\Api\Blog\CategoryGet::class, 'index']);
// Route::get('api/blog/categories', [\routes\Api\Blog\CategoryController::class, 'index']);
// Route::get('api/blog/categories/{id}', [\routes\Api\Blog\CategoryController::class, 'show']);
// Route::post('api/blog/categories/create', [\routes\Api\Blog\CategoryController::class, 'store']);
// Route::put('api/blog/categories/edit/{id}', [\routes\Api\Blog\CategoryController::class, 'update']);
// Route::delete('api/blog/categories/delete/{id}', [\routes\Api\Blog\CategoryController::class, 'destroy']);
//
