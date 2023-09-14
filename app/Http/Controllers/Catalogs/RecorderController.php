<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\OtherEquipments\Recorder;
use Illuminate\Http\Request;

class RecorderController extends Controller
{
    public function newRecorder(Request $request)
    {
        $brand = $request->input('brand');
        $model = $request->input('model');
        if (!$brand) {
            return $this->alerts(false, 'nullBrand', 'نام برند انتخاب نشده است');
        }
        if (!$model) {
            return $this->alerts(false, 'nullModel', 'مدل وارد نشده است');
        }

        $Recorder = new Recorder();
        $Recorder->company_id = $brand;
        $Recorder->model = $model;
        $Recorder->save();
        $this->logActivity('Recorder Added =>' . $Recorder->id, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'recorderAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function editRecorder(Request $request)
    {
        $RecorderID = $request->input('recorder_id');
        $brand = $request->input('brandForEdit');
        $model = $request->input('modelForEdit');
        if (!$brand) {
            return $this->alerts(false, 'nullBrand', 'نام برند انتخاب نشده است');
        }
        if (!$model) {
            return $this->alerts(false, 'nullModel', 'مدل وارد نشده است');
        }

        $Recorder = Recorder::find($RecorderID);
        $Recorder->fill([
            'company_id' => $brand,
            'model' => $model,
        ]);
        $Recorder->save();
        $this->logActivity('Recorder Edited =>' . $RecorderID, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'recorderEdited', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function getRecorderInfo(Request $request)
    {
        $RecorderID = $request->input('id');
        if ($RecorderID) {
            return Recorder::find($RecorderID);
        }
    }

    public function index()
    {
        $recorderList = Recorder::orderBy('company_id', 'asc')->paginate(20);
        return \view('Catalogs.OtherEquipments.RecorderCatalog', ['recorderList' => $recorderList]);
    }
}
