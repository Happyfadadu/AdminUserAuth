<?php

use App\Http\Controllers\Admin\AdminHomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\GuestMiddleware;
use App\Http\Middleware\UserMiddleware;

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

Route::prefix('admin')->name('admin.')->group(function () {

    Route::middleware([ GuestMiddleware::class])->group(function () {
        Route::get('/login', [AdminLoginController::class, 'index']);
        Route::post('/login', [AdminLoginController::class, 'login'])->name('login');
    });
    Route::middleware(['auth', AdminMiddleware::class])->group(function () {
        Route::get('/home', [AdminHomeController::class, 'index'])->name('home');
    });
});


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware(UserMiddleware::class);
