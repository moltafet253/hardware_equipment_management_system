<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\OtherEquipments\Speaker;
use Illuminate\Http\Request;

class SpeakerController extends Controller
{
    public function newSpeaker(Request $request)
    {
        $brand = $request->input('brand');
        $model = $request->input('model');
        if (!$brand) {
            return $this->alerts(false, 'nullBrand', 'نام برند انتخاب نشده است');
        }
        if (!$model) {
            return $this->alerts(false, 'nullModel', 'مدل وارد نشده است');
        }

        $Speaker = new Speaker();
        $Speaker->company_id = $brand;
        $Speaker->model = $model;
        $Speaker->save();
        $this->logActivity('Speaker Added =>' . $Speaker->id, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'speakerAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function editSpeaker(Request $request)
    {
        $SpeakerID = $request->input('speaker_id');
        $brand = $request->input('brandForEdit');
        $model = $request->input('modelForEdit');
        if (!$brand) {
            return $this->alerts(false, 'nullBrand', 'نام برند انتخاب نشده است');
        }
        if (!$model) {
            return $this->alerts(false, 'nullModel', 'مدل وارد نشده است');
        }

        $Speaker = Speaker::find($SpeakerID);
        $Speaker->fill([
            'company_id' => $brand,
            'model' => $model,
        ]);
        $Speaker->save();
        $this->logActivity('Speaker Edited =>' . $SpeakerID, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'speakerEdited', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function getSpeakerInfo(Request $request)
    {
        $SpeakerID = $request->input('id');
        if ($SpeakerID) {
            return Speaker::find($SpeakerID);
        }
    }

    public function index()
    {
        $speakerList = Speaker::orderBy('company_id', 'asc')->paginate(20);
        return \view('Catalogs.OtherEquipments.SpeakerCatalog', ['speakerList' => $speakerList]);
    }
}
