<?php

namespace App\Http\Controllers;

use App\Models\EquipmentedCase;
use App\Models\EquipmentedMonitor;
use App\Models\EquipmentedPrinter;
use App\Models\EquipmentedScanner;
use App\Models\EquipmentLog;
use Illuminate\Http\Request;

class EditEquipmentController extends Controller
{
    public function editEquipment(Request $request)
    {
        $eq_id = $request->input('eq_id');
        $eq_type=$request->input('eq_type');
        if ($eq_id) {
            switch ($eq_type) {
                case 'case':
                    $stamp_number = $request->input('edited_stamp_number');
                    $computer_name = $request->input('edited_computer_name');
                    $delivery_date = $request->input('edited_case_delivery_date');
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

                    $equipmentedDevice = EquipmentedCase::find($eq_id);

                    $originalData = $equipmentedDevice->getOriginal();

                    $equipmentedDevice->stamp_number = $stamp_number;
                    $equipmentedDevice->computer_name = $computer_name;
                    $equipmentedDevice->delivery_date = $delivery_date;
                    $equipmentedDevice->case = $caseInfo;
                    $equipmentedDevice->motherboard = $motherboard;
                    $equipmentedDevice->power = $power;
                    $equipmentedDevice->cpu = $cpu;
                    $equipmentedDevice->ram1 = $ram1;
                    $equipmentedDevice->ram2 = $ram2;
                    $equipmentedDevice->ram3 = $ram3;
                    $equipmentedDevice->ram4 = $ram4;
                    $equipmentedDevice->hdd1 = $hdd1;
                    $equipmentedDevice->hdd2 = $hdd2;
                    $equipmentedDevice->hdd3 = $hdd3;
                    $equipmentedDevice->hdd4 = $hdd4;
                    $equipmentedDevice->graphic_card = $graphiccard;
                    $equipmentedDevice->network_card = $networkcard;
                    $equipmentedDevice->save();

                    $updatedData = [
                        'stamp_number' => $stamp_number,
                        'computer_name' => $computer_name,
                        'delivery_date' => $delivery_date,
                        'case' => $caseInfo,
                        'motherboard' => $motherboard,
                        'power' => $power,
                        'cpu' => $cpu,
                        'ram1' => $ram1,
                        'ram2' => $ram2,
                        'ram3' => $ram3,
                        'ram4' => $ram4,
                        'hdd1' => $hdd1,
                        'hdd2' => $hdd2,
                        'hdd3' => $hdd3,
                        'hdd4' => $hdd4,
                        'graphic_card' => $graphiccard,
                        'network_card' => $networkcard,
                    ];

                    $this->logActivity('Equipmented Case Edited =>' . $equipmentedDevice->id, \request()->ip(), \request()->userAgent(), \session('id'));

                    break;
                case 'monitor':
                    $delivery_date = $request->input('edited_monitor_delivery_date');
                    $monitor = $request->input('edited_monitor');

                    if (!$monitor) {
                        return $this->alerts(false, 'nullMonitor', 'مانیتور انتخاب نشده است');
                    }

                    $equipmentedDevice = EquipmentedMonitor::find($eq_id);

                    $originalData = $equipmentedDevice->getOriginal();

                    $equipmentedDevice->delivery_date = $delivery_date;
                    $equipmentedDevice->monitor_id = $monitor;
                    $equipmentedDevice->save();

                    $updatedData = [
                        'delivery_date' => $delivery_date,
                        'monitor_id' => $monitor,
                    ];

                    $this->logActivity('Equipmented Monitor Edited =>' . $equipmentedDevice->id, \request()->ip(), \request()->userAgent(), \session('id'));

                    break;
                case 'printer':
                    $delivery_date = $request->input('edited_printer_delivery_date');
                    $printer = $request->input('edited_printer');

                    if (!$printer) {
                        return $this->alerts(false, 'nullPrinter', 'پرینتر انتخاب نشده است');
                    }

                    $equipmentedDevice = EquipmentedPrinter::find($eq_id);

                    $originalData = $equipmentedDevice->getOriginal();

                    $equipmentedDevice->delivery_date = $delivery_date;
                    $equipmentedDevice->printer_id = $printer;
                    $equipmentedDevice->save();

                    $updatedData = [
                        'delivery_date' => $delivery_date,
                        'printer_id' => $printer,
                    ];

                    $this->logActivity('Equipmented Printer Edited =>' . $equipmentedDevice->id, \request()->ip(), \request()->userAgent(), \session('id'));

                    break;
                case 'scanner':
                    $delivery_date = $request->input('edited_scanner_delivery_date');
                    $scanner = $request->input('edited_scanner');

                    if (!$scanner) {
                        return $this->alerts(false, 'nullPrinter', 'پرینتر انتخاب نشده است');
                    }

                    $equipmentedDevice = EquipmentedScanner::find($eq_id);

                    $originalData = $equipmentedDevice->getOriginal();

                    $equipmentedDevice->delivery_date = $delivery_date;
                    $equipmentedDevice->scanner_id = $scanner;
                    $equipmentedDevice->save();

                    $updatedData = [
                        'delivery_date' => $delivery_date,
                        'scanner_id' => $scanner,
                    ];

                    $this->logActivity('Equipmented Scanner Edited =>' . $equipmentedDevice->id, \request()->ip(), \request()->userAgent(), \session('id'));

                    break;
            }

            //Equipment Changes Log
            $changes = array_diff_assoc($updatedData, $originalData);

            if ($changes){
                $lastLog=EquipmentLog::where('property_number',$equipmentedDevice->property_number)->orderBy('id','desc')->first();
                $eq_log=new EquipmentLog();
                $eq_log->equipment_id=$eq_id;
                $eq_log->equipment_type=$eq_type;
                $eq_log->property_number=$lastLog->property_number;
                $eq_log->personal_code=$lastLog->personal_code;

                $changesArray = [];
                foreach ($changes as $field => $value) {
                    $previousValue = $originalData[$field];
                    $changesArray[] = [
                        'field' => $field,
                        'from' => $previousValue,
                        'to' => $value,
                    ];
                }

                $eq_log->title = json_encode($changesArray);
                $eq_log->operator=session('id');
                $eq_log->save();
            }

            return $this->success(true, 'Edited', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');

        }
    }
}
