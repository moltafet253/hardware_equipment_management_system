<?php

namespace App\Http\Controllers\Catalogs;

use App\Models\Catalogs\Voip;
use Illuminate\Http\Request;

class VOIPController extends \App\Http\Controllers\Controller
{
    public function newVOIP(Request $request)
    {
        $brand = $request->input('brand');
        $model = $request->input('model');
        if (!$brand) {
            return $this->alerts(false, 'nullBrand', 'نام برند انتخاب نشده است');
        }
        if (!$model) {
            return $this->alerts(false, 'nullModel', 'مدل وارد نشده است');
        }

        $Scanner = new VOIP();
        $Scanner->company_id = $brand;
        $Scanner->model = $model;
        $Scanner->save();
        $this->logActivity('VOIP Added =>' . $Scanner->id, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'VOIPAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }
    public function editVOIP(Request $request)
    {
        $VOIPID = $request->input('VOIP_id');
        $brand = $request->input('brandForEdit');
        $model = $request->input('modelForEdit');
        if (!$brand) {
            return $this->alerts(false, 'nullBrand', 'نام برند انتخاب نشده است');
        }
        if (!$model) {
            return $this->alerts(false, 'nullModel', 'مدل وارد نشده است');
        }

        $Scanner = VOIP::find($VOIPID);
        $Scanner->fill([
            'company_id' => $brand,
            'model' => $model,
        ]);
        $Scanner->save();
        $this->logActivity('VOIP Edited =>' . $VOIPID, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'VOIPEdited', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }
    public function getVOIPInfo(Request $request)
    {
        $VOIPID = $request->input('id');
        if ($VOIPID) {
            return VOIP::find($VOIPID);
        }
    }
    public function index()
    {
        $VOIPList = VOIP::orderBy('company_id', 'asc')->paginate(20);
        return \view('Catalogs.VOIPCatalog', ['VOIPList' => $VOIPList]);
    }
}
