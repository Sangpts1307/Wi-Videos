<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('test-view', [\App\Http\Controllers\TestView::class, 'test']);

// Route for render view blade
Route::get('login', [\App\Http\Controllers\AuthController::class, 'login']);
// Route::get('google-login-callback', [\App\Http\Controllers\AuthController::class, 'googleLogin']);
// Route::get('facebook-login-callback', [\App\Http\Controllers\AuthController::class, 'facebookLogin']);
Route::get('social-login-callback/{social}', [\App\Http\Controllers\AuthController::class, 'socialLogin']);
Route::get('home', [\App\Http\Controllers\HomeController::class, 'index']);
Route::get('logout', [\App\Http\Controllers\AuthController::class, 'logout']);

Route::post('/upload-video', [\App\Http\Controllers\HomeController::class, 'uploadVideo']);

// Local api get data for vue.js
Route::get('/get-video', [\App\Http\Controllers\HomeController::class, 'getVideo']);
