<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\OtherEquipments\Headphone;
use Illuminate\Http\Request;

class HeadphoneController extends Controller
{
    public function newHeadphone(Request $request)
    {
        $brand = $request->input('brand');
        $model = $request->input('model');
        if (!$brand) {
            return $this->alerts(false, 'nullBrand', 'نام برند انتخاب نشده است');
        }
        if (!$model) {
            return $this->alerts(false, 'nullModel', 'مدل وارد نشده است');
        }

        $Headphone = new Headphone();
        $Headphone->company_id = $brand;
        $Headphone->model = $model;
        $Headphone->save();
        $this->logActivity('Headphone Added =>' . $Headphone->id, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'headphoneAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function editHeadphone(Request $request)
    {
        $HeadphoneID = $request->input('headphone_id');
        $brand = $request->input('brandForEdit');
        $model = $request->input('modelForEdit');
        if (!$brand) {
            return $this->alerts(false, 'nullBrand', 'نام برند انتخاب نشده است');
        }
        if (!$model) {
            return $this->alerts(false, 'nullModel', 'مدل وارد نشده است');
        }

        $Headphone = Headphone::find($HeadphoneID);
        $Headphone->fill([
            'company_id' => $brand,
            'model' => $model,
        ]);
        $Headphone->save();
        $this->logActivity('Headphone Edited =>' . $HeadphoneID, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'headphoneEdited', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function getHeadphoneInfo(Request $request)
    {
        $HeadphoneID = $request->input('id');
        if ($HeadphoneID) {
            return Headphone::find($HeadphoneID);
        }
    }

    public function index()
    {
        $headphoneList = Headphone::orderBy('company_id', 'asc')->paginate(20);
        return \view('Catalogs.OtherEquipments.HeadphoneCatalog', ['headphoneList' => $headphoneList]);
    }
}
