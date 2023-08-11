<?php

use App\Http\Controllers\CaseController;
use App\Http\Controllers\Catalogs\BrandController;
use App\Http\Controllers\Catalogs\MotherboardController;
use App\Http\Controllers\CPUController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserManager;
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
        Route::middleware('roleAuthorization:1')->group(function () {
            Route::get('/Search', [SearchController::class, 'search'])->name('Search');
            //User Manager
            Route::get('/UserManager', [UserManager::class, 'index'])->name('UserManager');
            Route::get('/GetUserInfo', [UserManager::class, 'getUserInfo'])->name('GetUserInfo');
            Route::Post('/NewUser', [UserManager::class, 'newUser'])->name('NewUser');
            Route::Post('/EditUser', [UserManager::class, 'editUser'])->name('EditUser');
            Route::Post('/ChangeUserActivationStatus', [UserManager::class, 'changeUserActivationStatus'])->name('ChangeUserActivationStatus');
            Route::Post('/ChangeUserNTCP', [UserManager::class, 'ChangeUserNTCP'])->name('ChangeUserNTCP');
            Route::Post('/ResetPassword', [UserManager::class, 'ResetPassword'])->name('ResetPassword');

            //Catalogs
            Route::get('/Brands', [BrandController::class, 'index'])->name('Brands');
            Route::post('/newBrand', [BrandController::class, 'newBrand'])->name('newBrand');
            Route::get('/getBrandInfo', [BrandController::class, 'getBrandInfo'])->name('getBrandInfo');
            Route::post('/editBrand', [BrandController::class, 'editBrand'])->name('editBrand');

            Route::get('/MotherboardCatalog', [MotherboardController::class, 'index'])->name('MotherboardCatalog');
            Route::post('/newMotherboard', [MotherboardController::class, 'newMotherboard'])->name('newMotherboard');
            Route::get('/getMotherboardInfo', [MotherboardController::class, 'getMotherboardInfo'])->name('getMotherboardInfo');
            Route::post('/editMotherboard', [MotherboardController::class, 'editMotherboard'])->name('editMotherboard');

            Route::get('/CaseCatalog', [CaseController::class, 'index'])->name('CaseCatalog');
            Route::post('/newCase', [CaseController::class, 'newCase'])->name('newCase');
            Route::get('/getCaseInfo', [CaseController::class, 'getCaseInfo'])->name('getCaseInfo');
            Route::post('/editCase', [CaseController::class, 'editCase'])->name('editCase');

            Route::get('/CPUCatalog', [CPUController::class, 'index'])->name('CPUCatalog');
            Route::post('/newCPU', [CPUController::class, 'newCPU'])->name('newCPU');
            Route::get('/getCPUInfo', [CPUController::class, 'getCPUInfo'])->name('getCPUInfo');
            Route::post('/editCPU', [CPUController::class, 'editCPU'])->name('editCPU');


        });


        Route::middleware('roleAuthorization:2')->group(function () {
        });

    });
});

