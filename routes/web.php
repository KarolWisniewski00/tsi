<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleLoginController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
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
        Route::prefix('order')->group(function () {
            Route::get('/', [OrderController::class, 'index'])->name('dashboard.order');
            Route::get('/create', [OrderController::class, 'create'])->name('dashboard.order.create');
            Route::post('/store', [OrderController::class, 'store'])->name('dashboard.order.store');
            Route::get('/show/{slug}', [OrderController::class, 'show'])->name('dashboard.order.show');
            Route::get('/edit/{slug}', [OrderController::class, 'edit'])->name('dashboard.order.edit');
            Route::put('/update/{slug}', [OrderController::class, 'update'])->name('dashboard.order.update');
            Route::get('/delete/{slug}', [OrderController::class, 'delete'])->name('dashboard.order.delete');
        });
    });
});

Route::middleware('guest')->group(function () {
    Route::get('/login/google', [GoogleLoginController::class, 'redirectToProvider']);
    Route::get('/login/google/redirect', [GoogleLoginController::class, 'handleProviderRedirect']);
});
