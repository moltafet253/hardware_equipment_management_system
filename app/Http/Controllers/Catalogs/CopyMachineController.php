<?php

namespace App\Http\Controllers\Catalogs;

use App\Models\Catalogs\CopyMachine;
use Illuminate\Http\Request;

class CopyMachineController extends \App\Http\Controllers\Controller
{
    public function newCopyMachine(Request $request)
    {
        $brand = $request->input('brand');
        $model = $request->input('model');
        if (!$brand) {
            return $this->alerts(false, 'nullBrand', 'نام برند انتخاب نشده است');
        }
        if (!$model) {
            return $this->alerts(false, 'nullModel', 'مدل وارد نشده است');
        }

        $CopyMachine = new CopyMachine();
        $CopyMachine->company_id = $brand;
        $CopyMachine->model = $model;
        $CopyMachine->save();
        $this->logActivity('Copy Machine Added =>' . $CopyMachine->id, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'CopyMachineAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }
    public function editCopyMachine(Request $request)
    {
        $CopyMachineID = $request->input('copy_machine_id');
        $brand = $request->input('brandForEdit');
        $model = $request->input('modelForEdit');
        if (!$brand) {
            return $this->alerts(false, 'nullBrand', 'نام برند انتخاب نشده است');
        }
        if (!$model) {
            return $this->alerts(false, 'nullModel', 'مدل وارد نشده است');
        }

        $CopyMachine = CopyMachine::find($CopyMachineID);
        $CopyMachine->fill([
            'company_id' => $brand,
            'model' => $model,
        ]);
        $CopyMachine->save();
        $this->logActivity('Scanner Edited =>' . $CopyMachineID, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'CopyMachineEdited', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }
    public function getCopyMachineInfo(Request $request)
    {
        $copyMachineID = $request->input('id');
        if ($copyMachineID) {
            return CopyMachine::find($copyMachineID);
        }
    }
    public function index()
    {
        $copyMachineList = CopyMachine::orderBy('company_id', 'asc')->paginate(20);
        return \view('Catalogs.CopyMachineCatalog', ['copyMachineList' => $copyMachineList]);
    }
}
