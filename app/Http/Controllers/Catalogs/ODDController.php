<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\Odd;
use Illuminate\Http\Request;

class ODDController extends Controller
{
    public function newODD(Request $request)
    {
        $brand=$request->input('brand');
        $model=$request->input('model');
        $connectivity_type=$request->input('connectivity_type');
        if (!$brand){
            return $this->alerts(false, 'nullBrand', 'نام برند انتخاب نشده است');
        }
        if (!$model){
            return $this->alerts(false, 'nullModel', 'مدل وارد نشده است');
        }
        if (!$connectivity_type){
            return $this->alerts(false, 'nullConnectivityType', 'نوع اتصال انتخاب نشده است');
        }

        $ODD=new ODD();
        $ODD->company_id=$brand;
        $ODD->model=$model;
        $ODD->connectivity_type=$connectivity_type;
        $ODD->save();
        $this->logActivity('ODD Added =>' . $ODD->id , \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'ODDAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }
    public function editODD(Request $request)
    {
        $ODDID=$request->input('ODD_id');
        $brand=$request->input('brandForEdit');
        $model=$request->input('modelForEdit');
        $connectivity_type=$request->input('connectivity_typeForEdit');
        if (!$brand){
            return $this->alerts(false, 'nullBrand', 'نام برند انتخاب نشده است');
        }
        if (!$model){
            return $this->alerts(false, 'nullModel', 'مدل وارد نشده است');
        }
        if (!$connectivity_type){
            return $this->alerts(false, 'nullConnectivityType', 'نوع اتصال انتخاب نشده است');
        }

        $ODD=ODD::find($ODDID);
        $ODD->fill([
            'company_id' => $brand,
            'model' => $model,
            'connectivity_type' => $connectivity_type,
        ]);
        $ODD->save();
        $this->logActivity('RAM Edited =>' . $ODDID , \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'ODDEdited', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }
    public function getODDInfo(Request $request)
    {
        $ODDID=$request->input('id');
        if ($ODDID) {
            return ODD::find($ODDID);
        }
    }
    public function index()
    {
        $ODDList = ODD::orderBy('company_id', 'asc')->paginate(20);
        return \view('Catalogs.ODDCatalog', ['ODDList' => $ODDList]);
    }
}
