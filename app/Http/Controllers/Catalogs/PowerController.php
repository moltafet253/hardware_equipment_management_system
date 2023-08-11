<?php

namespace App\Http\Controllers\Catalogs;

use App\Models\Catalogs\Power;
use Illuminate\Http\Request;

class PowerController extends \App\Http\Controllers\Controller
{
    public function newPower(Request $request)
    {
        $brand = $request->input('brand');
        $model = $request->input('model');
        $voltage = $request->input('output_voltage');
        if (!$brand) {
            return $this->alerts(false, 'nullBrand', 'نام برند انتخاب نشده است');
        }
        if (!$model) {
            return $this->alerts(false, 'nullModel', 'مدل انتخاب نشده است');
        }
        if (!$voltage) {
            return $this->alerts(false, 'nullVoltage', 'ولتاژ خروجی وارد نشده است');
        }

        $Power = new Power();
        $Power->company_id = $brand;
        $Power->model = $model;
        $Power->output_voltage = $voltage;
        $Power->save();
        $this->logActivity('Power Added =>' . $Power->id, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'powerAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function editPower(Request $request)
    {
        $PowerID = $request->input('power_id');
        $brand = $request->input('brandForEdit');
        $model = $request->input('modelForEdit');
        $voltage = $request->input('output_voltageForEdit');
        if (!$brand) {
            return $this->alerts(false, 'nullBrand', 'نام برند انتخاب نشده است');
        }
        if (!$model) {
            return $this->alerts(false, 'nullModel', 'مدل انتخاب نشده است');
        }
        if (!$voltage) {
            return $this->alerts(false, 'nullVoltage', 'ولتاژ خروجی وارد نشده است');
        }

        $Power = Power::find($PowerID);
        $Power->fill([
            'company_id' => $brand,
            'model' => $model,
            'output_voltage' => $voltage,
        ]);
        $Power->save();
        $this->logActivity('Power Edited =>' . $Power, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'powerEdited', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function getPowerInfo(Request $request)
    {
        $powerID = $request->input('id');
        if ($powerID) {
            return Power::find($powerID);
        }
    }

    public function index()
    {
        $powerList = Power::orderBy('company_id', 'asc')->paginate(20);
        return \view('Catalogs.PowerCatalog', ['powerList' => $powerList]);
    }
}
