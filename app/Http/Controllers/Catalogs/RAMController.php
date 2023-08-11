<?php

namespace App\Http\Controllers\Catalogs;

use App\Models\Catalogs\Ram;
use Illuminate\Http\Request;

class RAMController extends \App\Http\Controllers\Controller
{
    public function newRAM(Request $request)
    {
        $brand=$request->input('brand');
        $model=$request->input('model');
        $type=$request->input('type');
        $size=$request->input('size');
        $frequency=$request->input('frequency');
        if (!$brand){
            return $this->alerts(false, 'nullBrand', 'نام برند انتخاب نشده است');
        }
        if (!$model){
            return $this->alerts(false, 'nullModel', 'مدل وارد نشده است');
        }
        if (!$type){
            return $this->alerts(false, 'nullType', 'نوع حافظه انتخاب نشده است');
        }
        if (!$frequency){
            return $this->alerts(false, 'nullFrequency', 'فرکانس وارد نشده است');
        }
        if (!$size){
            return $this->alerts(false, 'nullSize', 'سایز حافظه انتخاب نشده است');
        }

        $RAM=new RAM();
        $RAM->company_id=$brand;
        $RAM->model=$model;
        $RAM->type=$type;
        $RAM->size=$size;
        $RAM->frequency=$frequency;
        $RAM->save();
        $this->logActivity('RAM Added =>' . $RAM->id , \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'ramAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }
    public function editRAM(Request $request)
    {
        $RAMID=$request->input('ram_id');
        $brand=$request->input('brandForEdit');
        $model=$request->input('modelForEdit');
        $type=$request->input('typeForEdit');
        $size=$request->input('sizeForEdit');
        $frequency=$request->input('frequencyForEdit');
        if (!$brand){
            return $this->alerts(false, 'nullBrand', 'نام برند انتخاب نشده است');
        }
        if (!$model){
            return $this->alerts(false, 'nullModel', 'مدل وارد نشده است');
        }
        if (!$type){
            return $this->alerts(false, 'nullType', 'نوع حافظه انتخاب نشده است');
        }
        if (!$frequency){
            return $this->alerts(false, 'nullFrequency', 'فرکانس وارد نشده است');
        }
        if (!$size){
            return $this->alerts(false, 'nullSize', 'سایز حافظه انتخاب نشده است');
        }

        $RAM=RAM::find($RAMID);
        $RAM->fill([
            'company_id' => $brand,
            'model' => $model,
            'type' => $type,
            'size' => $size,
            'frequency' => $frequency,
        ]);
        $RAM->save();
        $this->logActivity('RAM Edited =>' . $RAMID , \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'ramEdited', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }
    public function getRAMInfo(Request $request)
    {
        $RAMID=$request->input('id');
        if ($RAMID) {
            return RAM::find($RAMID);
        }
    }
    public function index()
    {
        $ramList = RAM::orderBy('company_id', 'asc')->paginate(20);
        return \view('Catalogs.RAMCatalog', ['ramList' => $ramList]);
    }
}
