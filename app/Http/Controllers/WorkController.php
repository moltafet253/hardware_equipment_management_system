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
    public function index()
    {
        $nullMessage = "این دستگاه تغییری نداشته است!";
        return \view('History', ['message' => $nullMessage]);
    }

    public function getHistory(Request $request)
    {
        $property_number = $request->input('property_number');
        if (!$property_number) {
            $message="کد اموال وارد نشده است!";
            return \view('History', compact('message'));
        }
        $equipment_log = EquipmentLog::where('property_number', $property_number)->get();

        if ($equipment_log->count() == 0) {
            $message="دستگاهی با این کد اموال یافت نشد!";
            return \view('History', compact('message'));
        }
        return \view('History', compact('equipment_log'));


    }
}
