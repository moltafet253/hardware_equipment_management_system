<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\OtherEquipments\VideoProjectorCurtain;
use Illuminate\Http\Request;

class VideoProjectorCurtainController extends Controller
{
    public function newVideoProjectorCurtain(Request $request)
    {
        $brand = $request->input('brand');
        $model = $request->input('model');
        $size = $request->input('size');
        if (!$brand) {
            return $this->alerts(false, 'nullBrand', 'نام برند انتخاب نشده است');
        }
        if (!$model) {
            return $this->alerts(false, 'nullModel', 'مدل وارد نشده است');
        }
        if (!$size) {
            return $this->alerts(false, 'nullSize', 'سایز پرده وارد نشده است');
        }

        $VideoProjectorCurtain = new VideoProjectorCurtain();
        $VideoProjectorCurtain->company_id = $brand;
        $VideoProjectorCurtain->model = $model;
        $VideoProjectorCurtain->size = $size;
        $VideoProjectorCurtain->save();
        $this->logActivity('Video Projector Curtain Added =>' . $VideoProjectorCurtain->id, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'videoProjectorCurtainAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function editVideoProjectorCurtain(Request $request)
    {
        $VideoProjectorCurtainID = $request->input('videoProjectorCurtain_id');
        $brand = $request->input('brandForEdit');
        $model = $request->input('modelForEdit');
        $size = $request->input('sizeForEdit');

        if (!$brand) {
            return $this->alerts(false, 'nullBrand', 'نام برند انتخاب نشده است');
        }
        if (!$model) {
            return $this->alerts(false, 'nullModel', 'مدل وارد نشده است');
        }
        if (!$size) {
            return $this->alerts(false, 'nullSize', 'سایز پرده وارد نشده است');
        }

        $VideoProjectorCurtain = VideoProjectorCurtain::find($VideoProjectorCurtainID);
        $VideoProjectorCurtain->fill([
            'company_id' => $brand,
            'model' => $model,
            'size' => $size
        ]);
        $VideoProjectorCurtain->save();
        $this->logActivity('Video Projector Curtain Edited =>' . $VideoProjectorCurtainID, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'videoProjectorCurtainEdited', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function getVideoProjectorCurtainInfo(Request $request)
    {
        $VideoProjectorCurtainID = $request->input('id');
        if ($VideoProjectorCurtainID) {
            return VideoProjectorCurtain::find($VideoProjectorCurtainID);
        }
    }

    public function index()
    {
        $videoProjectorCurtainList = VideoProjectorCurtain::orderBy('company_id', 'asc')->paginate(20);
        return \view('Catalogs.OtherEquipments.VideoProjectorCurtainCatalog', ['videoProjectorCurtainList' => $videoProjectorCurtainList]);
    }
}
