<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChatController;
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

Route::get('/redis', fn () => Cache::put('key', 'value', 60));
Route::get('/redis/get', fn () => Cache::get('key'));

Route::prefix('auth')->group(function(Router $router) {
    $router->post('/register', [AuthController::class, 'register']);
    $router->post('/login', [AuthController::class, 'login']);
    $router->get('/logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->group(function(Router $router) {
    $router->apiResources([
        'products' => 'ProductController',
        'orders' => 'OrderController'
    ]);

    # User Related Routes
    $router->put('user/update/{userId}', [UserController::class, 'updateName']);
    $router->get('user/show/{userId}', [UserController::class, 'show']);
    $router->post('user/store-avatar', [UserController::class, 'storeAvatar']);
    $router->get('user/show-avatar/{userId}', [UserController::class, 'showAvatar']);

    # Chat Related Routes
    $router->get('chat/create-convo', [ChatController::class, 'createConvo']);
    $router->post('chat/send', [ChatController::class, 'sendMessage']);
});

