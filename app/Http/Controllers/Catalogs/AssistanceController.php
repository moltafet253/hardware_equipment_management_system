<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\Catalogs\Assistance;
use Illuminate\Http\Request;

class AssistanceController extends Controller
{
    public function newAssistance(Request $request)
    {
        $name = $request->input('name');
        if (!$name) {
            return $this->alerts(false, 'nullName', 'نام معاونت/بخش وارد نشده است');
        }
        $check = Assistance::where('name', $name)->first();
        if ($check) {
            return $this->alerts(false, 'dupName', 'نام معاونت/بخش تکراری وارد شده است');
        }
        $Assistance = new Assistance();
        $Assistance->name = $name;
        $Assistance->save();
        $this->logActivity('Assistance Added =>' . $Assistance->id, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'assistanceAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function editAssistance(Request $request)
    {
        $assistanceID = $request->input('assistance_id');
        $name = $request->input('nameForEdit');
        if (!$name) {
            return $this->alerts(false, 'nullName', 'نام معاونت/بخش وارد نشده است');
        }
        $check = Assistance::where('name', $name)->first();
        if ($check) {
            return $this->alerts(false, 'dupName', 'نام معاونت/بخش تکراری وارد شده است');
        }

        $Assistance = Assistance::find($assistanceID);
        $Assistance->fill([
            'name' => $name,
        ]);
        $Assistance->save();
        $this->logActivity('Assistance Edited =>' . $assistanceID, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'assistanceEdited', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function getAssistanceInfo(Request $request)
    {
        $assistanceID = $request->input('id');
        if ($assistanceID) {
            return Assistance::find($assistanceID);
        }
    }

    public function index()
    {
        $assistanceList = Assistance::orderBy('name', 'asc')->paginate(20);
        return \view('Catalogs.AssistanceCatalog', ['assistanceList' => $assistanceList]);
    }
}
