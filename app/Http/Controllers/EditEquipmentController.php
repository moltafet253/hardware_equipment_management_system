<?php

namespace App\Http\Controllers;

use App\Models\EquipmentedCase;
use App\Models\EquipmentedCopyMachine;
use App\Models\EquipmentedMonitor;
use App\Models\EquipmentedNetworkDevices\EquipmentedModem;
use App\Models\EquipmentedNetworkDevices\EquipmentedSwitch;
use App\Models\EquipmentedOtherDevices\EquipmentedHeadphone;
use App\Models\EquipmentedOtherDevices\EquipmentedMobile;
use App\Models\EquipmentedOtherDevices\EquipmentedRecorder;
use App\Models\EquipmentedOtherDevices\EquipmentedSpeaker;
use App\Models\EquipmentedOtherDevices\EquipmentedTablet;
use App\Models\EquipmentedOtherDevices\EquipmentedVideoProjector;
use App\Models\EquipmentedOtherDevices\EquipmentedVideoProjectorCurtain;
use App\Models\EquipmentedOtherDevices\EquipmentedWebcam;
use App\Models\EquipmentedPrinter;
use App\Models\EquipmentedScanner;
use App\Models\EquipmentedVoip;
use App\Models\EquipmentLog;
use App\Models\Person;
use Illuminate\Http\Request;

class EditEquipmentController extends Controller
{
    public function editEquipment(Request $request)
    {
        $eq_id = $request->input('eq_id');
        $eq_type = $request->input('eq_type');
        if ($eq_id) {
            switch ($eq_type) {
                case 'case':
                    $property_number = $request->input('edited_case_property_number');
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
                    $odd = $request->input('edited_odd');

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

                    $equipmentedDevice = EquipmentedCase::with('personInfo')->find($eq_id);
                    $checkPropertyNumber = EquipmentedCase::where('id', '!=', $eq_id)->where('property_number', $property_number)->first();

                    if ($checkPropertyNumber != null) {
                        return $this->alerts(false, 'dupPropertyNumber', 'کد اموال مربوط به کیس دیگری است');
                    }

                    $originalData = $equipmentedDevice->getOriginal();

                    $equipmentedDevice->property_number = $property_number;
                    $equipmentedDevice->stamp_number = $stamp_number;
                    $equipmentedDevice->computer_name = $computer_name;
                    $equipmentedDevice->delivery_date = $delivery_date;
                    $equipmentedDevice->case = $caseInfo;
                    $equipmentedDevice->motherboard = $motherboard;
                    $equipmentedDevice->power = $power;
                    $equipmentedDevice->cpu = $cpu;
                    $equipmentedDevice->ram1 = $ram1;
                    $equipmentedDevice->ram2 = $ram2;
                    if ($ram2 == null or $ram2 == 'فاقد رم') {
                        $equipmentedDevice->ram2 = null;
                    }
                    $equipmentedDevice->ram3 = $ram3;
                    if ($ram3 == null or $ram3 == 'فاقد رم') {
                        $equipmentedDevice->ram3 = null;
                    }
                    $equipmentedDevice->ram4 = $ram4;
                    if ($ram4 == null or $ram4 == 'فاقد رم') {
                        $equipmentedDevice->ram4 = null;
                    }
                    $equipmentedDevice->hdd1 = $hdd1;
                    $equipmentedDevice->hdd2 = $hdd2;
                    if ($hdd2 == null or $hdd2 == 'فاقد هارد') {
                        $equipmentedDevice->hdd2 = null;
                    }
                    $equipmentedDevice->hdd3 = $hdd3;
                    if ($hdd3 == null or $hdd3 == 'فاقد هارد') {
                        $equipmentedDevice->hdd3 = null;
                    }
                    $equipmentedDevice->hdd4 = $hdd4;
                    if ($hdd4 == null or $hdd4 == 'فاقد هارد') {
                        $equipmentedDevice->hdd4 = null;
                    }
                    if ($graphiccard == null or $graphiccard == 'فاقد کارت گرافیک') {
                        $equipmentedDevice->graphic_card = null;
                    }
                    if ($networkcard == null or $networkcard == 'فاقد کارت شبکه') {
                        $equipmentedDevice->network_card = null;
                    }
                    if ($odd == null or $odd == 'فاقد درایو نوری') {
                        $equipmentedDevice->odd = null;
                    }
                    $equipmentedDevice->save();

                    $updatedData = [
                        'property_number' => $property_number,
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
                        'odd' => $odd,
                    ];

                    $this->logActivity('Equipmented Case Edited =>' . $equipmentedDevice->id, \request()->ip(), \request()->userAgent(), \session('id'));

                    break;
                case 'monitor':
                    $property_number = $request->input('edited_monitor_property_number');
                    $delivery_date = $request->input('edited_monitor_delivery_date');
                    $monitor = $request->input('edited_monitor');

                    if (!$monitor) {
                        return $this->alerts(false, 'nullMonitor', 'مانیتور انتخاب نشده است');
                    }
                    if (!$property_number) {
                        return $this->alerts(false, 'nullPropertyNumber', 'کد اموال وارد نشده است');
                    }
                    $equipmentedDevice = EquipmentedMonitor::with('personInfo')->find($eq_id);
                    $checkPropertyNumber = EquipmentedMonitor::where('id', '!=', $eq_id)->where('property_number', $property_number)->first();

                    if ($checkPropertyNumber != null) {
                        return $this->alerts(false, 'dupPropertyNumber', 'کد اموال مربوط به مانیتور دیگری است');
                    }
                    $originalData = $equipmentedDevice->getOriginal();

                    $equipmentedDevice->property_number = $property_number;
                    $equipmentedDevice->delivery_date = $delivery_date;
                    $equipmentedDevice->monitor_id = $monitor;
                    $equipmentedDevice->save();

                    $updatedData = [
                        'property_number' => $property_number,
                        'delivery_date' => $delivery_date,
                        'monitor_id' => $monitor,
                    ];

                    $this->logActivity('Equipmented Monitor Edited =>' . $equipmentedDevice->id, \request()->ip(), \request()->userAgent(), \session('id'));

                    break;
                case 'printer':
                    $property_number = $request->input('edited_printer_property_number');
                    $delivery_date = $request->input('edited_printer_delivery_date');
                    $printer = $request->input('edited_printer');

                    if (!$printer) {
                        return $this->alerts(false, 'nullPrinter', 'پرینتر انتخاب نشده است');
                    }
                    if (!$property_number) {
                        return $this->alerts(false, 'nullPropertyNumber', 'کد اموال وارد نشده است');
                    }
                    $checkPropertyNumber = EquipmentedPrinter::where('id', '!=', $eq_id)->where('property_number', $property_number)->first();

                    if ($checkPropertyNumber != null) {
                        return $this->alerts(false, 'dupPropertyNumber', 'کد اموال مربوط به پرینتر دیگری است');
                    }
                    $equipmentedDevice = EquipmentedPrinter::with('personInfo')->find($eq_id);

                    $originalData = $equipmentedDevice->getOriginal();

                    $equipmentedDevice->property_number = $property_number;
                    $equipmentedDevice->delivery_date = $delivery_date;
                    $equipmentedDevice->printer_id = $printer;
                    $equipmentedDevice->save();

                    $updatedData = [
                        'property_number' => $property_number,
                        'delivery_date' => $delivery_date,
                        'printer_id' => $printer,
                    ];

                    $this->logActivity('Equipmented Printer Edited =>' . $equipmentedDevice->id, \request()->ip(), \request()->userAgent(), \session('id'));

                    break;
                case 'scanner':
                    $property_number = $request->input('edited_scanner_property_number');
                    $delivery_date = $request->input('edited_scanner_delivery_date');
                    $scanner = $request->input('edited_scanner');

                    if (!$scanner) {
                        return $this->alerts(false, 'nullPrinter', 'پرینتر انتخاب نشده است');
                    }
                    if (!$property_number) {
                        return $this->alerts(false, 'nullPropertyNumber', 'کد اموال وارد نشده است');
                    }
                    $checkPropertyNumber = EquipmentedScanner::where('id', '!=', $eq_id)->where('property_number', $property_number)->first();

                    if ($checkPropertyNumber != null) {
                        return $this->alerts(false, 'dupPropertyNumber', 'کد اموال مربوط به اسکنر دیگری است');
                    }
                    $equipmentedDevice = EquipmentedScanner::with('personInfo')->find($eq_id);

                    $originalData = $equipmentedDevice->getOriginal();

                    $equipmentedDevice->property_number = $property_number;

                    $equipmentedDevice->delivery_date = $delivery_date;
                    $equipmentedDevice->scanner_id = $scanner;
                    $equipmentedDevice->save();

                    $updatedData = [
                        'property_number' => $property_number,
                        'delivery_date' => $delivery_date,
                        'scanner_id' => $scanner,
                    ];

                    $this->logActivity('Equipmented Scanner Edited =>' . $equipmentedDevice->id, \request()->ip(), \request()->userAgent(), \session('id'));

                    break;
            }

            //Equipment Changes Log
            $changes = array_diff_assoc($updatedData, $originalData);

            if ($changes) {
                $lastLog = EquipmentLog::where('property_number', $equipmentedDevice->property_number)->orderBy('id', 'desc')->first();
                $eq_log = new EquipmentLog();
                $eq_log->equipment_id = $eq_id;
                $eq_log->equipment_type = $eq_type;
                if ($lastLog != null) {
                    $eq_log->property_number = $lastLog->property_number;
                    $eq_log->personal_code = $lastLog->personal_code;
                } else {
                    $eq_log->property_number = $equipmentedDevice->property_number;
                    $eq_log->personal_code = $equipmentedDevice->personInfo->id;
                }

                $changesArray = [];
                foreach ($changes as $field => $value) {
                    $previousValue = $originalData[$field];
                    $changesArray[] = [
                        'field' => $field,
                        'from' => $previousValue,
                        'to' => $value,
                    ];
                    if ($field == 'property_number') {
                        $this->logEquipmentChanges("Changed property number from => $previousValue to $value", $eq_id, $eq_type, $previousValue, \session('id'), $equipmentedDevice->personInfo->id);
                    }
                }

                $eq_log->title = json_encode($changesArray);
                $eq_log->operator = session('id');
                $eq_log->save();
            }

            return $this->success(true, 'Edited', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
        }
        abort(403);
    }

    public function moveEquipment(Request $request)
    {
        $eq_id = $request->input('eq_id');
        $eq_type = $request->input('eq_type');
        $person = $request->input('person');
        if (!$eq_id) {
            return $this->alerts(false, 'nullEquipment', 'دستگاه انتخاب نشده است');
        }
        if (!$eq_type) {
            return $this->alerts(false, 'nullEquipmentType', 'نوع دستگاه وارد نشده است');
        }
        if (!$person or $person==null) {
            return $this->alerts(false, 'nullPerson', 'پرسنل انتخاب نشده است');
        }
        switch ($eq_type){
            case 'case':
                $equipment=EquipmentedCase::find($eq_id);
                break;
            case 'monitor':
                $equipment=EquipmentedMonitor::find($eq_id);
                break;
            case 'printer':
                $equipment=EquipmentedPrinter::find($eq_id);
                break;
            case 'scanner':
                $equipment=EquipmentedScanner::find($eq_id);
                break;
            case 'copy machine':
                $equipment=EquipmentedCopyMachine::find($eq_id);
                break;
            case 'voip':
                $equipment=EquipmentedVoip::find($eq_id);
                break;
            case 'modem':
                $equipment=EquipmentedModem::find($eq_id);
                break;
            case 'switch':
                $equipment=EquipmentedSwitch::find($eq_id);
                break;
            case 'headphone':
                $equipment=EquipmentedHeadphone::find($eq_id);
                break;
            case 'mobile':
                $equipment=EquipmentedMobile::find($eq_id);
                break;
            case 'recorder':
                $equipment=EquipmentedRecorder::find($eq_id);
                break;
            case 'speaker':
                $equipment=EquipmentedSpeaker::find($eq_id);
                break;
            case 'tablet':
                $equipment=EquipmentedTablet::find($eq_id);
                break;
            case 'video projector curtain':
                $equipment=EquipmentedVideoProjectorCurtain::find($eq_id);
                break;
            case 'video projector':
                $equipment=EquipmentedVideoProjector::find($eq_id);
                break;
            case 'webcam':
                $equipment=EquipmentedWebcam::find($eq_id);
                break;
            default:
                return $this->alerts(false, 'error', 'خطای ناشناخته');
        }
        $fromPerson=$equipment->person_id;
        $equipment->person_id=$person;
        $equipment->save();

        $fromPersonInfo=Person::find($fromPerson);
        $toPersonInfo=Person::find($person);
        $log=['message'=>'Moved equipment', 'from'=>$fromPerson, 'to'=>$person];
        $this->logEquipmentChanges(json_encode($log), $eq_id, $eq_type, $equipment->property_number, \session('id'), $fromPerson);
        $this->logEquipmentChanges('Assigned to this user => ' . $toPersonInfo->personnel_code, $eq_id, $eq_type, $equipment->property_number, \session('id'), $person);
        $log=['message'=>'Device removed from personnel property','Device_info'=>$eq_id,'Device_type'=>$eq_type,'Personnel'=>$toPersonInfo->personnel_code];
        $this->logEquipmentChanges(json_encode($log,true), $eq_id, $eq_type, $equipment->property_number, \session('id'), $fromPerson);
        return $this->success(true, 'Moved', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');

    }
}
