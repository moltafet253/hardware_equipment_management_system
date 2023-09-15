<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\OtherEquipments\Tablet;
use Illuminate\Http\Request;

class TabletController extends Controller
{
    public function newTablet(Request $request)
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

        $Tablet = new Tablet();
        $Tablet->company_id = $brand;
        $Tablet->model = $model;
        $Tablet->ram = $ram;
        $Tablet->internal_memory = $internal_memory;
        $Tablet->simcards_number = $simcards_number;
        $Tablet->save();
        $this->logActivity('Tablet Added =>' . $Tablet->id, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'tabletAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function editTablet(Request $request)
    {
        $TabletID = $request->input('tablet_id');
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

        $Tablet = Tablet::find($TabletID);
        $Tablet->fill([
            'company_id' => $brand,
            'model' => $model,
            'ram' => $ram,
            'internal_memory' => $internal_memory,
            'simcards_number' => $simcards_number,
        ]);
        $Tablet->save();
        $this->logActivity('Tablet Edited =>' . $TabletID, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'tabletEdited', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function getTabletInfo(Request $request)
    {
        $TabletID = $request->input('id');
        if ($TabletID) {
            return Tablet::find($TabletID);
        }
    }

    public function index()
    {
        $tabletList = Tablet::orderBy('company_id', 'asc')->paginate(20);
        return \view('Catalogs.OtherEquipments.TabletCatalog', ['tabletList' => $tabletList]);
    }
}
