<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\OtherEquipments\Webcam;
use Illuminate\Http\Request;

class WebcamController extends Controller
{
    public function newWebcam(Request $request)
    {
        $brand = $request->input('brand');
        $model = $request->input('model');
        if (!$brand) {
            return $this->alerts(false, 'nullBrand', 'نام برند انتخاب نشده است');
        }
        if (!$model) {
            return $this->alerts(false, 'nullModel', 'مدل وارد نشده است');
        }

        $Webcam = new Webcam();
        $Webcam->company_id = $brand;
        $Webcam->model = $model;
        $Webcam->save();
        $this->logActivity('Webcam Added =>' . $Webcam->id, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'webcamAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function editWebcam(Request $request)
    {
        $WebcamID = $request->input('webcam_id');
        $brand = $request->input('brandForEdit');
        $model = $request->input('modelForEdit');
        if (!$brand) {
            return $this->alerts(false, 'nullBrand', 'نام برند انتخاب نشده است');
        }
        if (!$model) {
            return $this->alerts(false, 'nullModel', 'مدل وارد نشده است');
        }

        $Webcam = Webcam::find($WebcamID);
        $Webcam->fill([
            'company_id' => $brand,
            'model' => $model,
        ]);
        $Webcam->save();
        $this->logActivity('Webcam Edited =>' . $WebcamID, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'webcamEdited', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function getWebcamInfo(Request $request)
    {
        $WebcamID = $request->input('id');
        if ($WebcamID) {
            return Webcam::find($WebcamID);
        }
    }

    public function index()
    {
        $webcamList = Webcam::orderBy('company_id', 'asc')->paginate(20);
        return \view('Catalogs.OtherEquipments.WebcamCatalog', ['webcamList' => $webcamList]);
    }
}
