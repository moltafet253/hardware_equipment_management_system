<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\Scanner;
use Illuminate\Http\Request;

class ScannerController extends Controller
{
    public function newScanner(Request $request)
    {
        $brand = $request->input('brand');
        $model = $request->input('model');
        if (!$brand) {
            return $this->alerts(false, 'nullBrand', 'نام برند انتخاب نشده است');
        }
        if (!$model) {
            return $this->alerts(false, 'nullModel', 'مدل وارد نشده است');
        }

        $Scanner = new Scanner();
        $Scanner->company_id = $brand;
        $Scanner->model = $model;
        $Scanner->save();
        $this->logActivity('Scanner Added =>' . $Scanner->id, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'scannerAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }
    public function editScanner(Request $request)
    {
        $scannerID = $request->input('scanner_id');
        $brand = $request->input('brandForEdit');
        $model = $request->input('modelForEdit');
        if (!$brand) {
            return $this->alerts(false, 'nullBrand', 'نام برند انتخاب نشده است');
        }
        if (!$model) {
            return $this->alerts(false, 'nullModel', 'مدل وارد نشده است');
        }

        $Scanner = Scanner::find($scannerID);
        $Scanner->fill([
            'company_id' => $brand,
            'model' => $model,
        ]);
        $Scanner->save();
        $this->logActivity('Scanner Edited =>' . $scannerID, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'scannerEdited', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }
    public function getScannerInfo(Request $request)
    {
        $ScannerID = $request->input('id');
        if ($ScannerID) {
            return Scanner::find($ScannerID);
        }
    }
    public function index()
    {
        $scannerList = Scanner::orderBy('company_id', 'asc')->paginate(20);
        return \view('Catalogs.ScannerCatalog', ['scannerList' => $scannerList]);
    }
}
