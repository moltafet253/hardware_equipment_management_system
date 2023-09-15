<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\NetworkEquipments\Switches;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SwitchController extends Controller
{
    public function newSwitch(Request $request)
    {
        $brand = $request->input('brand');
        $model = $request->input('model');
        $ports_number = $request->input('ports_number');
        if (!$brand) {
            return $this->alerts(false, 'nullBrand', 'نام برند انتخاب نشده است');
        }
        if (!$model) {
            return $this->alerts(false, 'nullModel', 'مدل وارد نشده است');
        }
        if (!$ports_number) {
            return $this->alerts(false, 'nullPortsNumber', 'تعداد پورت وارد نشده است');
        }

        $Switch = new Switches();
        $Switch->company_id = $brand;
        $Switch->model = $model;
        $Switch->ports_number = $ports_number;
        $Switch->save();
        $this->logActivity('Switch Added =>' . $Switch->id, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'switchAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function editSwitch(Request $request)
    {
        $SwitchID = $request->input('switch_id');
        $brand = $request->input('brandForEdit');
        $model = $request->input('modelForEdit');
        $ports_number = $request->input('ports_numberForEdit');
        $validator = Validator::make($request->all(), [
            'ports_numberForEdit' => 'required|integer|max:100',
        ]);
        if ($validator->fails()) {
            return $this->alerts(false, 'wrongPortsNumber', 'تعداد پورت اشتباه وارد شده است.');
        }
        if (!$brand) {
            return $this->alerts(false, 'nullBrand', 'نام برند انتخاب نشده است');
        }
        if (!$model) {
            return $this->alerts(false, 'nullModel', 'مدل وارد نشده است');
        }
        if (!$ports_number) {
            return $this->alerts(false, 'nullPortsNumber', 'تعداد پورت وارد نشده است');
        }

        $Switch = Switches::find($SwitchID);
        $Switch->fill([
            'company_id' => $brand,
            'model' => $model,
            'ports_number' => $ports_number,
        ]);
        $Switch->save();
        $this->logActivity('Switch Edited =>' . $SwitchID, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'switchEdited', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function getSwitchInfo(Request $request)
    {
        $SwitchID = $request->input('id');
        if ($SwitchID) {
            return Switches::find($SwitchID);
        }
    }

    public function index()
    {
        $switchList = Switches::orderBy('company_id', 'asc')->paginate(20);
        return \view('Catalogs.NetworkEquipments.SwitchCatalog', ['switchList' => $switchList]);
    }
}
