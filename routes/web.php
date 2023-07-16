<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleLoginController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PusherController;

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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::prefix('dashboard')->group(function () {
        Route::get('/',[DashboardController::class, 'index'])->name('dashboard');

        Route::prefix('chat')->group(function () {
            Route::get('/', [PusherController::class, 'index'])->name('dashboard.chat');
            Route::post('/broadcast', [PusherController::class, 'broadcast'])->name('dashboard.chat.broadcast');
            Route::post('/receive', [PusherController::class, 'receive'])->name('dashboard.chat.receive');
        });
    });
});

Route::middleware('guest')->group(function () {
    Route::get('/login/google', [GoogleLoginController::class, 'redirectToProvider']);
    Route::get('/login/google/redirect', [GoogleLoginController::class, 'handleProviderRedirect']);
});
