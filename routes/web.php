<?php

use App\Http\Controllers\Catalogs\AssistanceController;
use App\Http\Controllers\Catalogs\BrandController;
use App\Http\Controllers\Catalogs\CaseController;
use App\Http\Controllers\Catalogs\CatalogController;
use App\Http\Controllers\Catalogs\CopyMachineController;
use App\Http\Controllers\Catalogs\CPUController;
use App\Http\Controllers\Catalogs\EstablishmentPlaceController;
use App\Http\Controllers\Catalogs\GraphicCardController;
use App\Http\Controllers\Catalogs\HarddiskController;
use App\Http\Controllers\Catalogs\HeadphoneController;
use App\Http\Controllers\Catalogs\JobController;
use App\Http\Controllers\Catalogs\LaptopController;
use App\Http\Controllers\Catalogs\MobileController;
use App\Http\Controllers\Catalogs\ModemController;
use App\Http\Controllers\Catalogs\MonitorController;
use App\Http\Controllers\Catalogs\MotherboardController;
use App\Http\Controllers\Catalogs\NetworkCardController;
use App\Http\Controllers\Catalogs\ODDController;
use App\Http\Controllers\Catalogs\PowerController;
use App\Http\Controllers\Catalogs\PrinterController;
use App\Http\Controllers\Catalogs\RAMController;
use App\Http\Controllers\Catalogs\RecorderController;
use App\Http\Controllers\Catalogs\ScannerController;
use App\Http\Controllers\Catalogs\SpeakerController;
use App\Http\Controllers\Catalogs\SwitchController;
use App\Http\Controllers\Catalogs\TabletController;
use App\Http\Controllers\Catalogs\VideoProjectorController;
use App\Http\Controllers\Catalogs\VideoProjectorCurtainController;
use App\Http\Controllers\Catalogs\VOIPController;
use App\Http\Controllers\Catalogs\WebcamController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\Reports\ExcelAllReportsController;
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
    Route::get('/dateandtime', [DashboardController::class, 'jalaliDateAndTime']);
    Route::get('/date', [DashboardController::class, 'jalaliDate']);
    Route::get('/Profile', [DashboardController::class, 'Profile'])->name('Profile');
    Route::post('/ChangePasswordInc', [DashboardController::class, 'ChangePasswordInc']);
    Route::post('/ChangeUserImage', [DashboardController::class, 'ChangeUserImage']);
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::middleware(NTCPMiddleware::class)->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        //Search Route
        Route::middleware('roleAuthorization:1')->group(callback: function () {
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

            //Hardware Catalogs
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

            Route::get('/CopyMachineCatalog', [CopyMachineController::class, 'index'])->name('CopyMachineCatalog');
            Route::post('/newCopyMachine', [CopyMachineController::class, 'newCopyMachine'])->name('newCopyMachine');
            Route::get('/getCopyMachineInfo', [CopyMachineController::class, 'getCopyMachineInfo'])->name('getCopyMachineInfo');
            Route::post('/editCopyMachine', [CopyMachineController::class, 'editCopyMachine'])->name('editCopyMachine');

            Route::get('/VOIPCatalog', [VOIPController::class, 'index'])->name('VOIPCatalog');
            Route::post('/newVOIP', [VOIPController::class, 'newVOIP'])->name('newVOIP');
            Route::get('/getVOIPInfo', [VOIPController::class, 'getVOIPInfo'])->name('getVOIPInfo');
            Route::post('/editVOIP', [VOIPController::class, 'editVOIP'])->name('editVOIP');
            //End Hardware Catalogs

            //Network Catalogs
            Route::get('/SwitchCatalog', [SwitchController::class, 'index']);
            Route::post('/newSwitch', [SwitchController::class, 'newSwitch']);
            Route::get('/getSwitchInfo', [SwitchController::class, 'getSwitchInfo']);
            Route::post('/editSwitch', [SwitchController::class, 'editSwitch']);

            Route::get('/ModemCatalog', [ModemController::class, 'index']);
            Route::post('/newModem', [ModemController::class, 'newModem']);
            Route::get('/getModemInfo', [ModemController::class, 'getModemInfo']);
            Route::post('/editModem', [ModemController::class, 'editModem']);
            //End Network Catalogs

            //Other Equipments Catalogs

            Route::get('/LaptopCatalog', [LaptopController::class, 'index']);
            Route::post('/newLaptop', [LaptopController::class, 'newLaptop']);
            Route::get('/getLaptopInfo', [LaptopController::class, 'getLaptopInfo']);
            Route::post('/editLaptop', [LaptopController::class, 'editLaptop']);

            Route::get('/MobileCatalog', [MobileController::class, 'index']);
            Route::post('/newMobile', [MobileController::class, 'newMobile']);
            Route::get('/getMobileInfo', [MobileController::class, 'getMobileInfo']);
            Route::post('/editMobile', [MobileController::class, 'editMobile']);

            Route::get('/TabletCatalog', [TabletController::class, 'index']);
            Route::post('/newTablet', [TabletController::class, 'newTablet']);
            Route::get('/getTabletInfo', [TabletController::class, 'getTabletInfo']);
            Route::post('/editTablet', [TabletController::class, 'editTablet']);

            Route::get('/WebcamCatalog', [WebcamController::class, 'index']);
            Route::post('/newWebcam', [WebcamController::class, 'newWebcam']);
            Route::get('/getWebcamInfo', [WebcamController::class, 'getWebcamInfo']);
            Route::post('/editWebcam', [WebcamController::class, 'editWebcam']);

            Route::get('/RecorderCatalog', [RecorderController::class, 'index']);
            Route::post('/newRecorder', [RecorderController::class, 'newRecorder']);
            Route::get('/getRecorderInfo', [RecorderController::class, 'getRecorderInfo']);
            Route::post('/editRecorder', [RecorderController::class, 'editRecorder']);

            Route::get('/HeadphoneCatalog', [HeadphoneController::class, 'index']);
            Route::post('/newHeadphone', [HeadphoneController::class, 'newHeadphone']);
            Route::get('/getHeadphoneInfo', [HeadphoneController::class, 'getHeadphoneInfo']);
            Route::post('/editHeadphone', [HeadphoneController::class, 'editHeadphone']);

            Route::get('/SpeakerCatalog', [SpeakerController::class, 'index']);
            Route::post('/newSpeaker', [SpeakerController::class, 'newSpeaker']);
            Route::get('/getSpeakerInfo', [SpeakerController::class, 'getSpeakerInfo']);
            Route::post('/editSpeaker', [SpeakerController::class, 'editSpeaker']);

            Route::get('/VideoProjectorCatalog', [VideoProjectorController::class, 'index']);
            Route::post('/newVideoProjector', [VideoProjectorController::class, 'newVideoProjector']);
            Route::get('/getVideoProjectorInfo', [VideoProjectorController::class, 'getVideoProjectorInfo']);
            Route::post('/editVideoProjector', [VideoProjectorController::class, 'editVideoProjector']);

            Route::get('/VideoProjectorCurtainCatalog', [VideoProjectorCurtainController::class, 'index']);
            Route::post('/newVideoProjectorCurtain', [VideoProjectorCurtainController::class, 'newVideoProjectorCurtain']);
            Route::get('/getVideoProjectorCurtainInfo', [VideoProjectorCurtainController::class, 'getVideoProjectorCurtainInfo']);
            Route::post('/editVideoProjectorCurtain', [VideoProjectorCurtainController::class, 'editVideoProjectorCurtain']);
            //End Other Equipments Catalogs

            //System Catalogs
            Route::get('/AssistanceCatalog', [AssistanceController::class, 'index'])->name('AssistanceCatalog');
            Route::post('/newAssistance', [AssistanceController::class, 'newAssistance'])->name('newAssistance');
            Route::get('/getAssistanceInfo', [AssistanceController::class, 'getAssistanceInfo'])->name('getAssistanceInfo');
            Route::post('/editAssistance', [AssistanceController::class, 'editAssistance'])->name('editAssistance');

            Route::get('/EstablishmentPlaceCatalog', [EstablishmentPlaceController::class, 'index'])->name('EstablishmentPlaceCatalog');
            Route::post('/newEstablishmentPlace', [EstablishmentPlaceController::class, 'newEstablishmentPlace'])->name('newEstablishmentPlace');
            Route::get('/getEstablishmentPlaceInfo', [EstablishmentPlaceController::class, 'getEstablishmentPlaceInfo'])->name('getEstablishmentPlaceInfo');
            Route::post('/editEstablishmentPlace', [EstablishmentPlaceController::class, 'editEstablishmentPlace'])->name('editEstablishmentPlace');

            Route::get('/JobCatalog', [JobController::class, 'index'])->name('JobCatalog');
            Route::post('/newJob', [JobController::class, 'newJob'])->name('newJob');
            Route::get('/getJobInfo', [JobController::class, 'getJobInfo'])->name('getJobInfo');
            Route::post('/editJob', [JobController::class, 'editJob'])->name('editJob');
            //End System Catalogs

            Route::post('/ManageCatalogStatus', [CatalogController::class, 'manage']);
            //End Catalogs

            Route::post('/newComment', [EquipmentController::class, 'newComment'])->name('newComment');

            //Start Reports
            //ExcelAllReports
            Route::get('/ExcelAllReports', [ExcelAllReportsController::class, 'index']);
            Route::get('/GetReport', [ExcelAllReportsController::class, 'getReport'])->name('GetReport');
            //End Reports
        });

        //Person Management
        Route::get('/Person', [PersonController::class, 'index'])->name('Person');
        Route::post('/newPerson', [PersonController::class, 'newPerson'])->name('newPerson');
        Route::get('/getPersonInfo', [PersonController::class, 'getPersonInfo'])->name('getPersonInfo');
        Route::post('/editPerson', [PersonController::class, 'editPerson'])->name('editPerson');
        //End Person Management

        //Equipment status
        Route::get('/showEquipmentStatus', [EquipmentController::class, 'showEquipmentStatus'])->name('showEquipmentStatus');

        //Hardware equipments
        Route::post('/newEquipmentCase', [EquipmentController::class, 'newCase']);
        Route::post('/newEquipmentMonitor', [EquipmentController::class, 'newMonitor']);
        Route::post('/newEquipmentPrinter', [EquipmentController::class, 'newPrinter']);
        Route::post('/newEquipmentScanner', [EquipmentController::class, 'newScanner']);
        Route::post('/newEquipmentCopyMachine', [EquipmentController::class, 'newCopyMachine']);
        Route::post('/newEquipmentVOIP', [EquipmentController::class, 'newVOIP']);

        //Network equipments
        Route::post('/newEquipmentModem', [EquipmentController::class, 'newModem']);
        Route::post('/newEquipmentSwitch', [EquipmentController::class, 'newSwitch']);

        //Other equipments
        Route::post('/newEquipmentHeadphone', [EquipmentController::class, 'newHeadphone']);
        Route::post('/newEquipmentLaptop', [EquipmentController::class, 'newLaptop']);
        Route::post('/newEquipmentMobile', [EquipmentController::class, 'newMobile']);
        Route::post('/newEquipmentRecorder', [EquipmentController::class, 'newRecorder']);
        Route::post('/newEquipmentSpeaker', [EquipmentController::class, 'newSpeaker']);
        Route::post('/newEquipmentTablet', [EquipmentController::class, 'newTablet']);
        Route::post('/newEquipmentVideoProjector', [EquipmentController::class, 'newVideoProjector']);
        Route::post('/newEquipmentVideoProjectorCurtain', [EquipmentController::class, 'newVideoProjectorCurtain']);
        Route::post('/newEquipmentWebcam', [EquipmentController::class, 'newWebcam']);

        //End equipment status

        Route::post('/editEquipment', [EquipmentController::class, 'editEquipment'])->name('editEquipment');

        Route::middleware('roleAuthorization:2')->group(function () {

        });
    });
});

