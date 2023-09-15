<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\OtherEquipments\VideoProjector;
use Illuminate\Http\Request;

class VideoProjectorController extends Controller
{
    public function newVideoProjector(Request $request)
    {
        $brand = $request->input('brand');
        $model = $request->input('model');
        if (!$brand) {
            return $this->alerts(false, 'nullBrand', 'نام برند انتخاب نشده است');
        }
        if (!$model) {
            return $this->alerts(false, 'nullModel', 'مدل وارد نشده است');
        }

        $VideoProjector = new VideoProjector();
        $VideoProjector->company_id = $brand;
        $VideoProjector->model = $model;
        $VideoProjector->save();
        $this->logActivity('Video Projector Added =>' . $VideoProjector->id, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'videoProjectorAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function editVideoProjector(Request $request)
    {
        $VideoProjectorID = $request->input('videoProjector_id');
        $brand = $request->input('brandForEdit');
        $model = $request->input('modelForEdit');
        if (!$brand) {
            return $this->alerts(false, 'nullBrand', 'نام برند انتخاب نشده است');
        }
        if (!$model) {
            return $this->alerts(false, 'nullModel', 'مدل وارد نشده است');
        }

        $VideoProjector = VideoProjector::find($VideoProjectorID);
        $VideoProjector->fill([
            'company_id' => $brand,
            'model' => $model,
        ]);
        $VideoProjector->save();
        $this->logActivity('Video Projector Edited =>' . $VideoProjectorID, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'videoProjectorEdited', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function getVideoProjectorInfo(Request $request)
    {
        $VideoProjectorID = $request->input('id');
        if ($VideoProjectorID) {
            return VideoProjector::find($VideoProjectorID);
        }
    }

    public function index()
    {
        $videoProjectorList = VideoProjector::orderBy('company_id', 'asc')->paginate(20);
        return \view('Catalogs.OtherEquipments.VideoProjectorCatalog', ['videoProjectorList' => $videoProjectorList]);
    }
}
