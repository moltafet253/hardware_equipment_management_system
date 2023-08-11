<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\Harddisk;
use Illuminate\Http\Request;

class HarddiskController extends Controller
{
    public function newHarddisk(Request $request)
    {
        $brand = $request->input('brand');
        $model = $request->input('model');
        $capacity = $request->input('capacity');
        $type = $request->input('type');
        $connectivity_type = $request->input('connectivity_type');
        if (!$brand) {
            return $this->alerts(false, 'nullBrand', 'نام برند انتخاب نشده است');
        }
        if (!$model) {
            return $this->alerts(false, 'nullModel', 'مدل وارد نشده است');
        }
        if (!$type) {
            return $this->alerts(false, 'nullType', 'نوع هارد انتخاب نشده است');
        }
        if (!$capacity) {
            return $this->alerts(false, 'nullCapacity', 'مقدار حافظه انتخاب نشده است');
        }
        if (!$connectivity_type) {
            return $this->alerts(false, 'nullConnectivityType', 'نوع اتصال انتخاب نشده است');
        }

        $Harddisk = new Harddisk();
        $Harddisk->company_id = $brand;
        $Harddisk->model = $model;
        $Harddisk->type = $type;
        $Harddisk->capacity = $capacity;
        $Harddisk->connectivity_type = $connectivity_type;
        $Harddisk->save();
        $this->logActivity('Hard Disk Added =>' . $Harddisk->id, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'harddiskAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function editHarddisk(Request $request)
    {
        $harddiskID = $request->input('harddisk_id');
        $brand = $request->input('brandForEdit');
        $model = $request->input('modelForEdit');
        $capacity = $request->input('capacityForEdit');
        $type = $request->input('typeForEdit');
        $connectivity_type = $request->input('connectivity_typeForEdit');
        if (!$brand) {
            return $this->alerts(false, 'nullBrand', 'نام برند انتخاب نشده است');
        }
        if (!$model) {
            return $this->alerts(false, 'nullModel', 'مدل وارد نشده است');
        }
        if (!$type) {
            return $this->alerts(false, 'nullType', 'نوع هارد انتخاب نشده است');
        }
        if (!$capacity) {
            return $this->alerts(false, 'nullCapacity', 'مقدار حافظه انتخاب نشده است');
        }
        if (!$connectivity_type) {
            return $this->alerts(false, 'nullConnectivityType', 'نوع اتصال انتخاب نشده است');
        }

        $harddisk = Harddisk::find($harddiskID);
        $harddisk->fill([
            'company_id' => $brand,
            'model' => $model,
            'type' => $type,
            'capacity' => $capacity,
            'connectivity_type' => $connectivity_type,
        ]);
        $harddisk->save();
        $this->logActivity('Hard Disk Edited =>' . $harddiskID, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'harddiskEdited', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function getHarddiskInfo(Request $request)
    {
        $harddiskID = $request->input('id');
        if ($harddiskID) {
            return Harddisk::find($harddiskID);
        }
    }

    public function index()
    {
        $harddiskList = Harddisk::orderBy('company_id', 'asc')->paginate(20);
        return \view('Catalogs.HarddiskCatalog', ['harddiskList' => $harddiskList]);
    }
}
