<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\NetworkEquipments\Modem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ModemController extends Controller
{
    public function newModem(Request $request)
    {
//        dd($request->all());
        $brand = $request->input('brand');
        $model = $request->input('model');
        $ports_number = $request->input('ports_number');
        $type = $request->input('type');
        $connectivity_type = $request->input('connectivity_type');

        $validator = Validator::make($request->all(), [
            'ports_number' => 'required|integer|max:8',
        ]);
        if (!$brand) {
            return $this->alerts(false, 'nullBrand', 'نام برند انتخاب نشده است');
        }
        if (!$model) {
            return $this->alerts(false, 'nullModel', 'مدل وارد نشده است');
        }
        if ($validator->fails()) {
            return $this->alerts(false, 'wrongPortsNumber', 'تعداد پورت اشتباه وارد شده است.');
        }
        if (!$type) {
            return $this->alerts(false, 'nullType', 'نوع مودم انتخاب نشده است');
        }
        if (!$connectivity_type) {
            return $this->alerts(false, 'nullConnectivityType', 'نوع اتصال به مودم انتخاب نشده است');
        }


        $connectivity_type=json_encode($connectivity_type);
        $Modem = new Modem();
        $Modem->company_id = $brand;
        $Modem->model = $model;
        $Modem->ports_number = $ports_number;
        $Modem->type = $type;
        $Modem->connectivity_type = $connectivity_type;
        $Modem->save();
        $this->logActivity('Modem Added =>' . $Modem->id, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'modemAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function editModem(Request $request)
    {
        $ModemID = $request->input('modem_id');
        $brand = $request->input('brandForEdit');
        $model = $request->input('modelForEdit');
        $ports_number = $request->input('ports_numberForEdit');
        $type = $request->input('typeForEdit');
        $connectivity_type = $request->input('connectivity_typeForEdit');
        $validator = Validator::make($request->all(), [
            'ports_numberForEdit' => 'required|integer|max:8',
        ]);
        if (!$brand) {
            return $this->alerts(false, 'nullBrand', 'نام برند انتخاب نشده است');
        }
        if (!$model) {
            return $this->alerts(false, 'nullModel', 'مدل وارد نشده است');
        }
        if ($validator->fails()) {
            return $this->alerts(false, 'wrongPortsNumber', 'تعداد پورت اشتباه وارد شده است.');
        }
        if (!$type) {
            return $this->alerts(false, 'nullType', 'نوع مودم انتخاب نشده است');
        }
        if (!$connectivity_type) {
            return $this->alerts(false, 'nullConnectivityType', 'نوع اتصال به مودم انتخاب نشده است');
        }

        $connectivity_type=json_encode($connectivity_type);

        $Modem = Modem::find($ModemID);
        $Modem->fill([
            'company_id' => $brand,
            'model' => $model,
            'ports_number' => $ports_number,
            'type' => $type,
            'connectivity_type' => $connectivity_type,
        ]);
        $Modem->save();
        $this->logActivity('Modem Edited =>' . $ModemID, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'modemEdited', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function getModemInfo(Request $request)
    {
        $ModemID = $request->input('id');
        if ($ModemID) {
            return Modem::find($ModemID);
        }
    }

    public function index()
    {
        $modemList = Modem::orderBy('company_id', 'asc')->paginate(20);
        $modemList->each(function ($connectivity_type) {
            $connectivity_type->connectivity_type = json_decode($connectivity_type->connectivity_type);
        });
        return \view('Catalogs.NetworkEquipments.ModemCatalog', ['modemList' => $modemList]);
    }
}
