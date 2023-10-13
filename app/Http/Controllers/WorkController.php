<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Device;
use App\Models\EquipmentedCase;
use App\Models\EquipmentedMonitor;
use App\Models\EquipmentLog;
use App\Models\Person;
use App\Models\User;
use Illuminate\Http\Request;

class WorkController extends Controller
{
    public function indexPropertyNumber()
    {
        $nullMessage = "این دستگاه تغییری نداشته است!";
        return \view('History.HistoryFromPropertyNumber', ['message' => $nullMessage]);
    }

    public function indexPersonalCode()
    {
        $nullMessage = "این دستگاه تغییری نداشته است!";
        return \view('History.HistoryFromPersonalCode', ['message' => $nullMessage]);
    }

    public function getPropertyNumberHistory(Request $request)
    {
        $property_number = $request->input('property_number');
        if (!$property_number) {
            $message="کد اموال وارد نشده است!";
            return \view('History.HistoryFromPropertyNumber', compact('message'));
        }
        $equipment_log = EquipmentLog::where('property_number', $property_number)->get();

        if ($equipment_log->count() == 0) {
            $message="دستگاهی با این کد اموال یافت نشد!";
            return \view('History.HistoryFromPropertyNumber', compact('message'));
        }
        return \view('History.HistoryFromPropertyNumber', compact('equipment_log'));


    }
    public function getPersonalCodeHistory(Request $request)
    {
        $personal_code = $request->input('personal_code');
        if (!$personal_code) {
            $message="کد اموال وارد نشده است!";
            return \view('History.HistoryFromPersonalCode', compact('message'));
        }

        $checkPerson=Person::where('personnel_code',$personal_code)->first();
        if ($checkPerson->count() == 0){
            $message=" کد پرسنلی یافت نشد!";
            return \view('History.HistoryFromPersonalCode', compact('message'));
        }
        $equipment_log = EquipmentLog::where('personal_code', $checkPerson->id)->get();

        if ($equipment_log->count() == 0) {
            $message="دستگاهی برای این کد پرسنلی یافت نشد!";
            return \view('History.HistoryFromPersonalCode', compact('message'));
        }
        return \view('History.HistoryFromPersonalCode', compact('equipment_log'));


    }
}
