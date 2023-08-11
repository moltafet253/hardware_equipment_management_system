<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\Monitor;
use Illuminate\Http\Request;

class MonitorController extends Controller
{
    public function newMonitor(Request $request)
    {
        $brand=$request->input('brand');
        $model=$request->input('model');
        $size=$request->input('size');
        if (!$brand){
            return $this->alerts(false, 'nullBrand', 'نام برند انتخاب نشده است');
        }
        if (!$model){
            return $this->alerts(false, 'nullModel', 'مدل وارد نشده است');
        }
        if (!$size){
            return $this->alerts(false, 'nullSize', 'سایز مانیتور انتخاب نشده است');
        }

        $Monitor=new Monitor();
        $Monitor->company_id=$brand;
        $Monitor->model=$model;
        $Monitor->size=$size;
        $Monitor->save();
        $this->logActivity('Monitor Added =>' . $Monitor->id , \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'MonitorAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }
    public function editMonitor(Request $request)
    {
        $MonitorID=$request->input('Monitor_id');
        $brand=$request->input('brandForEdit');
        $model=$request->input('modelForEdit');
        $size=$request->input('sizeForEdit');
        if (!$brand){
            return $this->alerts(false, 'nullBrand', 'نام برند انتخاب نشده است');
        }
        if (!$model){
            return $this->alerts(false, 'nullModel', 'مدل وارد نشده است');
        }
        if (!$size){
            return $this->alerts(false, 'nullSize', 'سایز مانیتور انتخاب نشده است');
        }

        $Monitor=Monitor::find($MonitorID);
        $Monitor->fill([
            'company_id' => $brand,
            'model' => $model,
            'size' => $size,
        ]);
        $Monitor->save();
        $this->logActivity('Monitor Edited =>' . $MonitorID , \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'MonitorEdited', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }
    public function getMonitorInfo(Request $request)
    {
        $MonitorID=$request->input('id');
        if ($MonitorID) {
            return Monitor::find($MonitorID);
        }
    }
    public function index()
    {
        $monitorList = Monitor::orderBy('company_id', 'asc')->paginate(20);
        return \view('Catalogs.MonitorCatalog', ['monitorList' => $monitorList]);
    }
}
