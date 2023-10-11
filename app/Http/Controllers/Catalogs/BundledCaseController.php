<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\BundledCase;
use Illuminate\Http\Request;

class BundledCaseController extends Controller
{
    public function newBundledCase(Request $request)
    {
        $caseInfo = $request->input('case');
        $motherboard = $request->input('motherboard');
        $power = $request->input('power');
        $cpu = $request->input('cpu');
        $ram1 = $request->input('ram1');
        $ram2 = $request->input('ram2');
        $ram3 = $request->input('ram3');
        $ram4 = $request->input('ram4');
        $hdd1 = $request->input('hdd1');
        $hdd2 = $request->input('hdd2');
        $hdd3 = $request->input('hdd3');
        $hdd4 = $request->input('hdd4');
        $graphiccard = $request->input('graphiccard');
        $networkcard = $request->input('networkcard');

        if (!$caseInfo) {
            return $this->alerts(false, 'nullCaseInfo', 'کیس انتخاب نشده است');
        }
        if (!$motherboard) {
            return $this->alerts(false, 'nullMotherboard', 'مادربورد انتخاب نشده است');
        }
        if (!$power) {
            return $this->alerts(false, 'nullPower', 'منبع تغذیه انتخاب نشده است');
        }
        if (!$cpu) {
            return $this->alerts(false, 'nullCPU', 'پردازنده انتخاب نشده است');
        }
        if (!$ram1) {
            return $this->alerts(false, 'nullRAM', 'رم انتخاب نشده است');
        }
        if (!$hdd1) {
            return $this->alerts(false, 'nullHDD', 'هارد انتخاب نشده است');
        }
        if (!$networkcard) {
            $networkcard = 1;
        }

        $data = [
            'case' => $caseInfo,
            'motherboard' => $motherboard,
            'power' => $power,
            'cpu' => $cpu,
            'ram1' => $ram1,
            'ram2' => $ram2,
            'ram3' => $ram3,
            'ram4' => $ram4,
            'hdd1' => $hdd1,
            'hdd2' => $hdd2,
            'hdd3' => $hdd3,
            'hdd4' => $hdd4,
            'graphiccard' => $graphiccard,
            'networkcard' => $networkcard,
        ];

        $bundle = json_encode($data);

        $case = new BundledCase();
        $case->bundle_info = $bundle;
        $case->save();
        $this->logActivity('Bundled Case Added =>' . $case->id, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'caseAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }
    public function getBundledCaseInfo(Request $request)
    {
        $BundledCaseID = $request->input('id');
        if ($BundledCaseID) {
            return BundledCase::find($BundledCaseID);
        }
    }

    public function removeBundledCase(Request $request)
    {
        $BundledCaseID = $request->input('id');
        if ($BundledCaseID) {
            $case=BundledCase::find($BundledCaseID);
            $case->delete();
            $this->logActivity('Bundled Case Deleted =>' . $case->id, \request()->ip(), \request()->userAgent(), \session('id'));
            return $this->success(true, 'caseDeleted', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
        }
            return $this->alerts(false, 'nullCase', 'کیس انتخاب نشده است');
    }
    public function index()
    {
        $bundledCaseList = BundledCase::paginate(20);
        return \view('Catalogs.BundledCasesCatalog', ['bundledCaseList' => $bundledCaseList]);
    }
}
