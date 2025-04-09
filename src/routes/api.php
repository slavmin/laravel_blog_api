<?php

use Illuminate\Support\Facades\Route;
// Middlewares
use App\Http\Middleware\EnsureUserHasAdminRole;
// All
use App\Http\Controllers\Tag\TagController;
use App\Http\Controllers\Post\PostController;
use App\Http\Controllers\Image\ImageController;
use App\Http\Controllers\Tag\PublicTagController;
use App\Http\Controllers\Post\PublicPostController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Category\PublicCategoryController;
// Auth
use App\Http\Controllers\Api\Auth\MeController;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RegisterController;
// User
use App\Http\Controllers\User\UserController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Public routes
Route::group([
    'prefix' => 'public',
    'middleware' => 'throttle:60,1',
], function (): void {
    // Posts
    Route::group(['prefix' => 'posts'], function (): void {
        Route::get('/', [PublicPostController::class, 'index']);
        Route::get('/{slug}', [PublicPostController::class, 'showBySlug']);
        Route::get('/tag/{slug}', [PublicPostController::class, 'showByTag']);
        Route::get('/category/{slug}', [PublicPostController::class, 'showByCategory']);
    });

    // Tags
    Route::group(['prefix' => 'tags'], function (): void {
        Route::get('/', [PublicTagController::class, 'index']);
        Route::get('/{slug}', [PublicTagController::class, 'showBySlug']);
    });

    // Categories
    Route::group(['prefix' => 'categories'], function (): void {
        Route::get('/', [PublicCategoryController::class, 'index']);
        Route::get('/{category}', [PublicCategoryController::class, 'showBySlug']);
    });
});

// Authorized users routes
Route::group(['middleware' => 'auth:sanctum'], function (): void {
    // Posts
    Route::apiResource('posts', PostController::class);
    Route::group(['prefix' => 'posts'], function (): void {
        Route::patch('/{post}/restore', [PostController::class, 'restore']);
        Route::delete('/{post}/force', [PostController::class, 'delete']);
    });

    // Tags
    Route::apiResource('tags', TagController::class);
    Route::group(['prefix' => 'tags'], function (): void {
        Route::patch('/{tag}/restore', [TagController::class, 'restore']);
        Route::delete('/{tag}/force', [TagController::class, 'delete']);
    });

    // Categories
    Route::apiResource('categories', CategoryController::class);
    Route::group(['prefix' => 'categories'], function (): void {
        Route::patch('/{category}/restore', [CategoryController::class, 'restore']);
        Route::delete('/{category}/force', [CategoryController::class, 'delete']);
    });

    // Images
    Route::group(['prefix' => 'images'], function (): void {
        Route::get('/', [ImageController::class, 'index']);
        Route::get('/{tag}', [ImageController::class, 'show']);
        Route::post('/', [ImageController::class, 'store']);
    });

    // Users
    Route::group(['prefix' => 'users'], function (): void {
        Route::get('/', [UserController::class, 'index'])->middleware(EnsureUserHasAdminRole::class);
        Route::post('/{user}/assign-role', [UserController::class, 'assignRole'])->middleware(EnsureUserHasAdminRole::class);
        Route::delete('/{user}/remove-role', [UserController::class, 'removeRole'])->middleware(EnsureUserHasAdminRole::class);
    });

    // Auth
    Route::group(['prefix' => 'auth'], function (): void {
        Route::get('/user', MeController::class);
        Route::post('/logout', LogoutController::class);
    });
});

// Auth routes
Route::group(['middleware' => ['guest:api', 'throttle:10,1']], function (): void {
    Route::group(['prefix' => 'auth'], function (): void {
        Route::post('/login', LoginController::class);
        Route::post('/register', RegisterController::class);

        // Password Reset Routes...
        // Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail']);
        // Route::post('/password/reset', [ForgotPasswordController::class, 'reset']);
    });
});
