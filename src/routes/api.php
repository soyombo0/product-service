<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

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

Route::prefix('auth')->group(function(Router $router) {
    $router->post('/register', [AuthController::class, 'register']);
    $router->post('/login', [AuthController::class, 'login']);
    $router->get('/logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->group(function(Router $router) {
    $router->apiResources([
        'products' => 'ProductController',
    ]);

    # User Related Routes
    $router->put('user/update/{userId}', [UserController::class, 'updateName']);
    $router->get('user/show/{userId}', [UserController::class, 'show']);
    $router->post('user/store-avatar', [UserController::class, 'storeAvatar']);
    $router->get('user/show-avatar/{userId}', [UserController::class, 'showAvatar']);
});

