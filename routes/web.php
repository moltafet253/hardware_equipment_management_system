<?php

use App\Http\Controllers\Catalogs\Car;
use App\Http\Controllers\ContractorController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoadController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrganizationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RiderController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\TariffController;
use App\Http\Controllers\UserManager;
use App\Http\Controllers\WeighbridgeController;
use App\Http\Middleware\CheckLoginMiddleware;
use App\Http\Middleware\MenuMiddleware;
use App\Http\Middleware\NTCPMiddleware;
use App\Http\Middleware\ThrottleRequests;
use Illuminate\Support\Facades\Auth;
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


//Login Routes
Route::get('/', function () {
    if (!Auth::check()) {
        return redirect()->route('login');
    }
    return redirect()->route('dashboard');
});
Route::get('/home', function () {
    Auth::logout();
    return redirect()->route('login');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::middleware(ThrottleRequests::class)->post('/login', [LoginController::class, 'login']);
Route::get('/captcha', [LoginController::class, 'getCaptcha'])->name('captcha');


//Panel Routes
Route::middleware(CheckLoginMiddleware::class)->middleware(MenuMiddleware::class)->group(function () {
    Route::get('/date', [DashboardController::class, 'jalaliDate'])->name('getNow');
    Route::get('/ChangePassword', [DashboardController::class, 'ChangePassword'])->name('ChangePassword');
    Route::post('/ChangePasswordInc', [DashboardController::class, 'ChangePasswordInc'])->name('ChangePasswordInc');
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::middleware(NTCPMiddleware::class)->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        //Search Route
        Route::get('/Search', [SearchController::class, 'search'])->name('Search');
        Route::middleware('roleAuthorization:1')->group(function () {

            //User Manager
            Route::get('/UserManager', [UserManager::class, 'index'])->name('UserManager');
            Route::get('/GetUserInfo', [UserManager::class, 'getUserInfo'])->name('GetUserInfo');
            Route::Post('/NewUser', [UserManager::class, 'newUser'])->name('NewUser');
            Route::Post('/EditUser', [UserManager::class, 'editUser'])->name('EditUser');
            Route::Post('/ChangeUserActivationStatus', [UserManager::class, 'changeUserActivationStatus'])->name('ChangeUserActivationStatus');
            Route::Post('/ChangeUserNTCP', [UserManager::class, 'ChangeUserNTCP'])->name('ChangeUserNTCP');
            Route::Post('/ResetPassword', [UserManager::class, 'ResetPassword'])->name('ResetPassword');
        });
        Route::middleware('roleAuthorization:2')->group(function () {
        });

    });
});

