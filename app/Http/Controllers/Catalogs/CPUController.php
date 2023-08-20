<?php

namespace App\Http\Controllers\Catalogs;

use App\Models\Catalogs\cpu;
use Illuminate\Http\Request;

class CPUController extends \App\Http\Controllers\Controller
{
    public function newCPU(Request $request)
    {
        $brand = $request->input('brand');
        $model = $request->input('model');
        $generation = $request->input('generation');
        if (!$brand) {
            return $this->alerts(false, 'nullBrand', 'نام برند انتخاب نشده است');
        }
        if (!$model) {
            return $this->alerts(false, 'nullModel', 'مدل وارد نشده است');
        }
//        if (!$generation) {
//            return $this->alerts(false, 'nullGeneration', 'نسل وارد نشده است');
//        }

        $CPU = new cpu();
        $CPU->company_id = $brand;
        $CPU->model = $model;
        $CPU->generation = $generation;
        $CPU->save();
        $this->logActivity('CPU Added =>' . $CPU->id, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'cpuAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function editCPU(Request $request)
    {
        $CPUID = $request->input('cpu_id');
        $brand = $request->input('brandForEdit');
        $model = $request->input('modelForEdit');
        $generation = $request->input('generationForEdit');
        if (!$brand) {
            return $this->alerts(false, 'nullBrand', 'نام برند انتخاب نشده است');
        }
        if (!$model) {
            return $this->alerts(false, 'nullModel', 'مدل وارد نشده است');
        }
        if (!$generation) {
            return $this->alerts(false, 'nullGeneration', 'نسل وارد نشده است');
        }

        $CPU = cpu::find($CPUID);
        $CPU->fill([
            'company_id' => $brand,
            'model' => $model,
            'generation' => $generation,
        ]);
        $CPU->save();
        $this->logActivity('CPU Edited =>' . $CPUID, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'cpuEdited', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function getCPUInfo(Request $request)
    {
        $cpuID = $request->input('id');
        if ($cpuID) {
            return cpu::find($cpuID);
        }
    }

    public function index()
    {
        $cpuList = cpu::orderBy('company_id', 'asc')->paginate(20);
        return \view('Catalogs.CPUCatalog', ['cpuList' => $cpuList]);
    }
}
