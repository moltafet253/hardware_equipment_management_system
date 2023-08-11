<?php

use App\Http\Controllers\Catalogs\BrandController;
use App\Http\Controllers\Catalogs\CaseController;
use App\Http\Controllers\Catalogs\CPUController;
use App\Http\Controllers\Catalogs\GraphicCardController;
use App\Http\Controllers\Catalogs\HarddiskController;
use App\Http\Controllers\Catalogs\MonitorController;
use App\Http\Controllers\Catalogs\MotherboardController;
use App\Http\Controllers\Catalogs\NetworkCardController;
use App\Http\Controllers\Catalogs\ODDController;
use App\Http\Controllers\Catalogs\PowerController;
use App\Http\Controllers\Catalogs\PrinterController;
use App\Http\Controllers\Catalogs\RAMController;
use App\Http\Controllers\Catalogs\ScannerController;
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

            Route::get('/RAMCatalog', [RAMController::class, 'index'])->name('RAMCatalog');
            Route::post('/newRAM', [RAMController::class, 'newRAM'])->name('newRAM');
            Route::get('/getRAMInfo', [RAMController::class, 'getRAMInfo'])->name('getRAMInfo');
            Route::post('/editRAM', [RAMController::class, 'editRAM'])->name('editRAM');

            Route::get('/PowerCatalog', [PowerController::class, 'index'])->name('PowerCatalog');
            Route::post('/newPower', [PowerController::class, 'newPower'])->name('newPower');
            Route::get('/getPowerInfo', [PowerController::class, 'getPowerInfo'])->name('getPowerInfo');
            Route::post('/editPower', [PowerController::class, 'editPower'])->name('editPower');

            Route::get('/GraphicCardCatalog', [GraphicCardController::class, 'index'])->name('GraphicCardCatalog');
            Route::post('/newGraphicCard', [GraphicCardController::class, 'newGraphicCard'])->name('newGraphicCard');
            Route::get('/getGraphicCardInfo', [GraphicCardController::class, 'getGraphicCardInfo'])->name('getGraphicCardInfo');
            Route::post('/editGraphicCard', [GraphicCardController::class, 'editGraphicCard'])->name('editGraphicCard');

            Route::get('/HarddiskCatalog', [HarddiskController::class, 'index'])->name('HarddiskCatalog');
            Route::post('/newHarddisk', [HarddiskController::class, 'newHarddisk'])->name('newHarddisk');
            Route::get('/getHarddiskInfo', [HarddiskController::class, 'getHarddiskInfo'])->name('getHarddiskInfo');
            Route::post('/editHarddisk', [HarddiskController::class, 'editHarddisk'])->name('editHarddisk');

            Route::get('/ODDCatalog', [ODDController::class, 'index'])->name('ODDCatalog');
            Route::post('/newODD', [ODDController::class, 'newODD'])->name('newODD');
            Route::get('/getODDInfo', [ODDController::class, 'getODDInfo'])->name('getODDInfo');
            Route::post('/editODD', [ODDController::class, 'editODD'])->name('editODD');

            Route::get('/NetworkCardCatalog', [NetworkCardController::class, 'index'])->name('NetworkCardCatalog');
            Route::post('/newNetworkCard', [NetworkCardController::class, 'newNetworkCard'])->name('newNetworkCard');
            Route::get('/getNetworkCardInfo', [NetworkCardController::class, 'getNetworkCardInfo'])->name('getNetworkCardInfo');
            Route::post('/editNetworkCard', [NetworkCardController::class, 'editNetworkCard'])->name('editNetworkCard');

            Route::get('/MonitorCatalog', [MonitorController::class, 'index'])->name('MonitorCatalog');
            Route::post('/newMonitor', [MonitorController::class, 'newMonitor'])->name('newMonitor');
            Route::get('/getMonitorInfo', [MonitorController::class, 'getMonitorInfo'])->name('getMonitorInfo');
            Route::post('/editMonitor', [MonitorController::class, 'editMonitor'])->name('editMonitor');

            Route::get('/PrinterCatalog', [PrinterController::class, 'index'])->name('PrinterCatalog');
            Route::post('/newPrinter', [PrinterController::class, 'newPrinter'])->name('newPrinter');
            Route::get('/getPrinterInfo', [PrinterController::class, 'getPrinterInfo'])->name('getPrinterInfo');
            Route::post('/editPrinter', [PrinterController::class, 'editPrinter'])->name('editPrinter');

            Route::get('/ScannerCatalog', [ScannerController::class, 'index'])->name('ScannerCatalog');
            Route::post('/newScanner', [ScannerController::class, 'newScanner'])->name('newScanner');
            Route::get('/getScannerInfo', [ScannerController::class, 'getScannerInfo'])->name('getScannerInfo');
            Route::post('/editScanner', [ScannerController::class, 'editScanner'])->name('editScanner');


        });
        Route::middleware('roleAuthorization:2')->group(function () {
        });

    });
});

