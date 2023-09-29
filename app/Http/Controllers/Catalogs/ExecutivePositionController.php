<?php

namespace App\Http\Controllers\Catalogs;

use App\Http\Controllers\Controller;
use App\Models\ExecutivePosition;
use Illuminate\Http\Request;

class ExecutivePositionController extends Controller
{
    public function newExecutivePosition(Request $request)
    {
        $title = $request->input('title');
        if (!$title) {
            return $this->alerts(false, 'nullName', 'نام سمت اجرایی وارد نشده است');
        }
        $check = ExecutivePosition::where('title', $title)->first();
        if ($check) {
            return $this->alerts(false, 'dupName', 'نام سمت اجرایی تکراری وارد شده است');
        }
        $executivePosition = new ExecutivePosition();
        $executivePosition->title = $title;
        $executivePosition->save();
        $this->logActivity('Executive Position Added =>' . $executivePosition->id, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'executivePositionAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function editExecutivePosition(Request $request)
    {
        $assistanceID = $request->input('executivePosition_id');
        $title = $request->input('titleForEdit');
        if (!$title) {
            return $this->alerts(false, 'nullName', 'نام سمت اجرایی وارد نشده است');
        }
        $check = ExecutivePosition::where('title', $title)->first();
        if ($check) {
            return $this->alerts(false, 'dupName', 'نام سمت اجرایی تکراری وارد شده است');
        }

        $Assistance = ExecutivePosition::find($assistanceID);
        $Assistance->fill([
            'title' => $title,
        ]);
        $Assistance->save();
        $this->logActivity('Executive Position Edited =>' . $assistanceID, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'executivePositionEdited', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function getExecutivePositionInfo(Request $request)
    {
        $assistanceID = $request->input('id');
        if ($assistanceID) {
            return ExecutivePosition::find($assistanceID);
        }
    }

    public function index()
    {
        $executivePositionList = ExecutivePosition::orderBy('title', 'asc')->paginate(20);
        return \view('Catalogs.ExecutivePositionCatalog', ['executivePositionList' => $executivePositionList]);
    }
}
