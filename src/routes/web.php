<?php

use App\Http\Controllers\API\V1\ChatController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/chat', [ChatController::class, 'index']);
Route::post('/broadcast', [ChatController::class, 'broadcast']);
Route::post('/receive', [ChatController::class, 'receive']);
