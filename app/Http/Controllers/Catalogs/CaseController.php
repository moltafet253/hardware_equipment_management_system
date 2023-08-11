<?php

namespace App\Http\Controllers\Catalogs;

use App\Models\Catalogs\Cases;
use Illuminate\Http\Request;

class CaseController extends \App\Http\Controllers\Controller
{
    public function newCase(Request $request)
    {
        $brand = $request->input('brand');
        $model = $request->input('model');
        if (!$brand) {
            return $this->alerts(false, 'nullBrand', 'نام برند انتخاب نشده است');
        }
        if (!$model) {
            return $this->alerts(false, 'nullModel', 'مدل وارد نشده است');
        }

        $MB = new Cases();
        $MB->company_id = $brand;
        $MB->model = $model;
        $MB->save();
        $this->logActivity('Case Added =>' . $MB->id, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'caseAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function editCase(Request $request)
    {
        $CaseID = $request->input('case_id');
        $brand = $request->input('brandForEdit');
        $model = $request->input('modelForEdit');
        if (!$brand) {
            return $this->alerts(false, 'nullBrand', 'نام برند انتخاب نشده است');
        }
        if (!$model) {
            return $this->alerts(false, 'nullModel', 'مدل وارد نشده است');
        }

        $MB = Cases::find($CaseID);
        $MB->fill([
            'company_id' => $brand,
            'model' => $model,
        ]);
        $MB->save();
        $this->logActivity('Case Edited =>' . $CaseID, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'caseEdited', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function getCaseInfo(Request $request)
    {
        $caseID = $request->input('id');
        if ($caseID) {
            return Cases::find($caseID);
        }
    }

    public function index()
    {
        $caseList = Cases::orderBy('company_id', 'asc')->paginate(20);
        return \view('Catalogs.CaseCatalog', ['caseList' => $caseList]);
    }
}
