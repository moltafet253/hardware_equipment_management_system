<?php

namespace App\Http\Controllers;

use App\Models\EquipmentedCase;
use Illuminate\Http\Request;

class EditEquipmentController extends Controller
{
    public function editEquipment(Request $request)
    {
        $eq_id = $request->input('eq_id');

        if ($eq_id) {
            switch ($request->input('eq_type')) {
                case 'case':
                    $property_number = $request->input('edited_property_number');
                    $stamp_number = $request->input('edited_stamp_number');
                    $computer_name = $request->input('edited_computer_name');
                    $delivery_date = $request->input('edited_delivery_date');
                    $caseInfo = $request->input('edited_case');
                    $motherboard = $request->input('edited_motherboard');
                    $power = $request->input('edited_power');
                    $cpu = $request->input('edited_cpu');
                    $ram1 = $request->input('edited_ram1');
                    $ram2 = $request->input('edited_ram2');
                    $ram3 = $request->input('edited_ram3');
                    $ram4 = $request->input('edited_ram4');
                    $hdd1 = $request->input('edited_hdd1');
                    $hdd2 = $request->input('edited_hdd2');
                    $hdd3 = $request->input('edited_hdd3');
                    $hdd4 = $request->input('edited_hdd4');
                    $graphiccard = $request->input('edited_graphiccard');
                    $networkcard = $request->input('edited_networkcard');

                    if (!$property_number) {
                        return $this->alerts(false, 'nullPropertyNumber', 'کد اموال وارد نشده است');
                    }
                    if (!$stamp_number) {
                        return $this->alerts(false, 'nullStampNumber', 'شماره پلمپ وارد نشده است');
                    }
                    if (!$caseInfo) {
                        return $this->alerts(false, 'nullCaseInfo', 'کیس انتخاب نشده است');
                    }
                    if (!$motherboard) {
                        return $this->alerts(false, 'nullMotherboard', 'مادربورد انتخاب نشده است');
                    }
                    if (!$power) {
                        return $this->alerts(false, 'nullPower', 'منبع تغذیه انتخاب نشده است');
                    }
                    if (!$cpu) {
                        return $this->alerts(false, 'nullCPU', 'پردازنده انتخاب نشده است');
                    }
                    if (!$ram1) {
                        return $this->alerts(false, 'nullRAM', 'رم انتخاب نشده است');
                    }
                    if (!$hdd1) {
                        return $this->alerts(false, 'nullHDD', 'هارد انتخاب نشده است');
                    }
                    if (!$networkcard) {
                        $networkcard = 1;
                    }

                    $case = EquipmentedCase::find($eq_id);
                    $case->property_number = $property_number;
                    $case->stamp_number = $stamp_number;
                    $case->computer_name = $computer_name;
                    $case->delivery_date = $delivery_date;
                    $case->case = $caseInfo;
                    $case->motherboard = $motherboard;
                    $case->power = $power;
                    $case->cpu = $cpu;
                    $case->ram1 = $ram1;
                    $case->ram2 = $ram2;
                    $case->ram3 = $ram3;
                    $case->ram4 = $ram4;
                    $case->hdd1 = $hdd1;
                    $case->hdd2 = $hdd2;
                    $case->hdd3 = $hdd3;
                    $case->hdd4 = $hdd4;
                    $case->graphic_card = $graphiccard;
                    $case->network_card = $networkcard;
                    $case->save();
                    $this->logActivity('Equipmented Case Edited =>' . $case->id, \request()->ip(), \request()->userAgent(), \session('id'));
                    return $this->success(true, 'caseEdited', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
                    break;
            }
        }
    }
}
