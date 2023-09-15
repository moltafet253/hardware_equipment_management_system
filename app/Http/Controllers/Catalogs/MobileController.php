<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\OtherEquipments\Mobile;
use Illuminate\Http\Request;

class MobileController extends Controller
{
    public function newMobile(Request $request)
    {
        $brand = $request->input('brand');
        $model = $request->input('model');
        $ram = $request->input('ram');
        $internal_memory = $request->input('internal_memory');
        $simcards_number = $request->input('simcards_number');
        if (!$brand) {
            return $this->alerts(false, 'nullBrand', 'نام برند انتخاب نشده است');
        }
        if (!$model) {
            return $this->alerts(false, 'nullModel', 'مدل وارد نشده است');
        }
        if (!$ram) {
            return $this->alerts(false, 'nullRam', 'مقدار رم انتخاب نشده است');
        }
        if (!$internal_memory) {
            return $this->alerts(false, 'nullInternalMemory', 'حافظه داخلی انتخاب نشده است');
        }
        if (!$simcards_number) {
            return $this->alerts(false, 'nullSimcardsNumber', 'تعداد سیمکارت انتخاب نشده است');
        }

        $Mobile = new Mobile();
        $Mobile->company_id = $brand;
        $Mobile->model = $model;
        $Mobile->ram = $ram;
        $Mobile->internal_memory = $internal_memory;
        $Mobile->simcards_number = $simcards_number;
        $Mobile->save();
        $this->logActivity('Mobile Added =>' . $Mobile->id, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'mobileAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function editMobile(Request $request)
    {
        $MobileID = $request->input('mobile_id');
        $brand = $request->input('brandForEdit');
        $model = $request->input('modelForEdit');
        $ram = $request->input('ramForEdit');
        $internal_memory = $request->input('internal_memoryForEdit');
        $simcards_number = $request->input('simcards_numberForEdit');
        if (!$brand) {
            return $this->alerts(false, 'nullBrand', 'نام برند انتخاب نشده است');
        }
        if (!$model) {
            return $this->alerts(false, 'nullModel', 'مدل وارد نشده است');
        }
        if (!$ram) {
            return $this->alerts(false, 'nullRam', 'مقدار رم انتخاب نشده است');
        }
        if (!$internal_memory) {
            return $this->alerts(false, 'nullInternalMemory', 'حافظه داخلی انتخاب نشده است');
        }
        if (!$simcards_number) {
            return $this->alerts(false, 'nullSimcardsNumber', 'تعداد سیمکارت انتخاب نشده است');
        }

        $Mobile = Mobile::find($MobileID);
        $Mobile->fill([
            'company_id' => $brand,
            'model' => $model,
            'ram' => $ram,
            'internal_memory' => $internal_memory,
            'simcards_number' => $simcards_number,
        ]);
        $Mobile->save();
        $this->logActivity('Mobile Edited =>' . $MobileID, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'mobileEdited', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function getMobileInfo(Request $request)
    {
        $MobileID = $request->input('id');
        if ($MobileID) {
            return Mobile::find($MobileID);
        }
    }

    public function index()
    {
        $mobileList = Mobile::orderBy('company_id', 'asc')->paginate(20);
        return \view('Catalogs.OtherEquipments.MobileCatalog', ['mobileList' => $mobileList]);
    }
}
