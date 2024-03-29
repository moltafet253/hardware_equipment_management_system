<?php

namespace App\Http\Controllers;

use App\Models\Catalogs\Job;
use App\Models\Catalogs\NetworkEquipments\Switches;
use App\Models\Comment;
use App\Models\EquipmentedCase;
use App\Models\EquipmentedCopyMachine;
use App\Models\EquipmentedMonitor;
use App\Models\EquipmentedNetworkDevices\EquipmentedModem;
use App\Models\EquipmentedNetworkDevices\EquipmentedSwitch;
use App\Models\EquipmentedOtherDevices\EquipmentedHeadphone;
use App\Models\EquipmentedOtherDevices\EquipmentedLaptop;
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
use App\Models\User;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function showEquipmentStatus(Request $request)
    {
        $personId = $request->input('id');
        $me = User::find(session('id'));
        if ($me->type != 1) {
            $check = Person::find($personId);
            if ($check->work_place == $me->province_id) {
                return view('EquipmentStatus', ['personId' => $personId]);
            }
            abort(403, 'access denied');
        }
        $allPersons = Person::where('id', '!=', $personId)->orderby('family','asc')->get();
        return view('EquipmentStatus', ['personId' => $personId, 'allPersons' => $allPersons]);
    }

    public function checkAccessingPerson($personId)
    {
        $me = User::find(session('id'));
        $person = Person::find($personId);
        if ($person->work_place != $me->province_id) {
            return false;
        }
        return true;
    }

    public function checkPropertyNumber($pNumber,$eqType)
    {
        switch ($eqType){
            case 'case':
                $check = EquipmentedCase::where('property_number', $pNumber)->first();
                break;
            case 'monitor':
                $check=EquipmentedMonitor::where('property_number', $pNumber)->first();
                break;
            case 'printer':
                $check=EquipmentedPrinter::where('property_number', $pNumber)->first();
                break;
            case 'scanner':
                $check=EquipmentedScanner::where('property_number', $pNumber)->first();
                break;
            case 'copy machine':
                $check=EquipmentedCopyMachine::where('property_number', $pNumber)->first();
                break;
            case 'voip':
                $check=EquipmentedVoip::where('property_number', $pNumber)->first();
                break;
            case 'modem':
                $check=EquipmentedModem::where('property_number', $pNumber)->first();
                break;
            case 'switch':
                $check=EquipmentedSwitch::where('property_number', $pNumber)->first();
                break;
            case 'headphone':
                $check=EquipmentedHeadphone::where('property_number', $pNumber)->first();
                break;
            case 'mobile':
                $check=EquipmentedMobile::where('property_number', $pNumber)->first();
                break;
            case 'recorder':
                $check=EquipmentedRecorder::where('property_number', $pNumber)->first();
                break;
            case 'speaker':
                $check=EquipmentedSpeaker::where('property_number', $pNumber)->first();
                break;
            case 'tablet':
                $check=EquipmentedTablet::where('property_number', $pNumber)->first();
                break;
            case 'video projector curtain':
                $check=EquipmentedVideoProjectorCurtain::where('property_number', $pNumber)->first();
                break;
            case 'video projector':
                $check=EquipmentedVideoProjector::where('property_number', $pNumber)->first();
                break;
            case 'webcam':
                $check=EquipmentedWebcam::where('property_number', $pNumber)->first();
                break;
            default:
                return $this->alerts(false, 'error', 'خطای ناشناخته');
        }
        if ($check) {
            return true;
        }
        return false;
    }

    public function newCase(Request $request)
    {
        $personID = $request->input('person');
        if (!$this->checkAccessingPerson($personID)) {
            return $this->alerts(false, 'wrongPerson', 'access denied');
        }

        $property_number = $request->input('property_number');
        if ($this->checkPropertyNumber($property_number,'case')) {
            return $this->alerts(false, 'duplicatePropertyNumber', 'کد اموال تکراری وارد شده است');
        }

        $stamp_number = $request->input('stamp_number');
        $computer_name = $request->input('computer_name');
        $delivery_date = $request->input('delivery_date');
        $caseInfo = $request->input('case');
        $motherboard = $request->input('motherboard');
        $power = $request->input('power');
        $cpu = $request->input('cpu');
        $ram1 = $request->input('ram1');
        $ram2 = $request->input('ram2');
        $ram3 = $request->input('ram3');
        $ram4 = $request->input('ram4');
        $hdd1 = $request->input('hdd1');
        $hdd2 = $request->input('hdd2');
        $hdd3 = $request->input('hdd3');
        $hdd4 = $request->input('hdd4');
        $graphiccard = $request->input('graphiccard');
        $networkcard = $request->input('networkcard');
        $odd = $request->input('odd');

        if (!$personID) {
            return $this->alerts(false, 'nullPersonnelCode', 'کد پرسنلی وارد نشده است');
        }
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

        $case = new EquipmentedCase();
        $case->person_id = $personID;
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
        if ($ram2 == null or $ram2 == 'فاقد رم') {
            $case->ram2 = null;
        }
        $case->ram3 = $ram3;
        if ($ram3 == null or $ram3 == 'فاقد رم') {
            $case->ram3 = null;
        }
        $case->ram4 = $ram4;
        if ($ram4 == null or $ram4 == 'فاقد رم') {
            $case->ram4 = null;
        }
        $case->hdd1 = $hdd1;
        $case->hdd2 = $hdd2;
        if ($hdd2 == null or $hdd2 == 'فاقد هارد') {
            $case->hdd2 = null;
        }
        $case->hdd3 = $hdd3;
        if ($hdd3 == null or $hdd3 == 'فاقد هارد') {
            $case->hdd3 = null;
        }
        $case->hdd4 = $hdd4;
        if ($hdd4 == null or $hdd4 == 'فاقد هارد') {
            $case->hdd4 = null;
        }
        if ($graphiccard == null or $graphiccard == 'فاقد کارت گرافیک') {
            $case->graphic_card = null;
        }
        if ($networkcard == null or $networkcard == 'فاقد کارت شبکه') {
            $case->network_card = null;
        }
        if ($odd == null or $odd == 'فاقد درایو نوری') {
            $case->odd = null;
        }
        $case->save();
        $this->logActivity('Equipmented Case Added =>' . $case->id, \request()->ip(), \request()->userAgent(), \session('id'));

        $person = Person::find($personID);
        $this->logEquipmentChanges('Equipment Added', $case->id, 'case', $property_number, \session('id'), $personID);
        $this->logEquipmentChanges('Assigned to this user => ' . $person->personnel_code, $case->id, 'case', $property_number, \session('id'), $personID);
        return $this->success(true, 'caseAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');

    }

    public function newMonitor(Request $request)
    {
        $personID = $request->input('person');
        if (!$this->checkAccessingPerson($personID)) {
            return $this->alerts(false, 'wrongPerson', 'access denied');
        }

        $property_number = $request->input('property_number');
        if ($this->checkPropertyNumber($property_number,'monitor')) {
            return $this->alerts(false, 'duplicatePropertyNumber', 'کد اموال تکراری وارد شده است');
        }

        $delivery_date = $request->input('delivery_date');
        $monitor = $request->input('monitor');

        if (!$personID) {
            return $this->alerts(false, 'nullPersonnelCode', 'کد پرسنلی وارد نشده است');
        }
        if (!$property_number) {
            return $this->alerts(false, 'nullPropertyNumber', 'کد اموال وارد نشده است');
        }
        if (!$monitor) {
            return $this->alerts(false, 'nullMonitor', 'مانیتور انتخاب نشده است');
        }

        $newmonitor = new EquipmentedMonitor();
        $newmonitor->person_id = $personID;
        $newmonitor->property_number = $property_number;
        $newmonitor->delivery_date = $delivery_date;
        $newmonitor->monitor_id = $monitor;
        $newmonitor->save();
        $this->logActivity('Equipmented Monitor Added =>' . $newmonitor->id, \request()->ip(), \request()->userAgent(), \session('id'));

        $person = Person::find($personID);
        $this->logEquipmentChanges('Equipment Added', $newmonitor->id, 'monitor', $property_number, \session('id'), $personID);
        $this->logEquipmentChanges('Assigned to this user => ' . $person->personnel_code, $newmonitor->id, 'monitor', $property_number, \session('id'), $personID);
        return $this->success(true, 'monitorAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');

    }

    public function newPrinter(Request $request)
    {
        $personID = $request->input('person');
        if (!$this->checkAccessingPerson($personID)) {
            return $this->alerts(false, 'wrongPerson', 'access denied');
        }

        $property_number = $request->input('property_number');
        if ($this->checkPropertyNumber($property_number,'printer')) {
            return $this->alerts(false, 'duplicatePropertyNumber', 'کد اموال تکراری وارد شده است');
        }

        $delivery_date = $request->input('delivery_date');
        $printer = $request->input('printer');

        if (!$personID) {
            return $this->alerts(false, 'nullPersonnelCode', 'کد پرسنلی وارد نشده است');
        }
        if (!$property_number) {
            return $this->alerts(false, 'nullPropertyNumber', 'کد اموال وارد نشده است');
        }
        if (!$printer) {
            return $this->alerts(false, 'nullPrinter', 'مانیتور انتخاب نشده است');
        }

        $newprinter = new EquipmentedPrinter();
        $newprinter->person_id = $personID;
        $newprinter->property_number = $property_number;
        $newprinter->delivery_date = $delivery_date;
        $newprinter->printer_id = $printer;
        $newprinter->save();
        $this->logActivity('Equipmented Printer Added =>' . $newprinter->id, \request()->ip(), \request()->userAgent(), \session('id'));

        $person = Person::find($personID);
        $this->logEquipmentChanges('Equipment Added', $newprinter->id, 'printer', $property_number, \session('id'), $personID);
        $this->logEquipmentChanges('Assigned to this user => ' . $person->personnel_code, $newprinter->id, 'printer', $property_number, \session('id'), $personID);
        return $this->success(true, 'printerAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function newScanner(Request $request)
    {
        $personID = $request->input('person');
        if (!$this->checkAccessingPerson($personID)) {
            return $this->alerts(false, 'wrongPerson', 'access denied');
        }

        $property_number = $request->input('property_number');
        if ($this->checkPropertyNumber($property_number,'scanner')) {
            return $this->alerts(false, 'duplicatePropertyNumber', 'کد اموال تکراری وارد شده است');
        }

        $delivery_date = $request->input('delivery_date');
        $scanner = $request->input('scanner');

        if (!$personID) {
            return $this->alerts(false, 'nullPersonnelCode', 'کد پرسنلی وارد نشده است');
        }
        if (!$property_number) {
            return $this->alerts(false, 'nullPropertyNumber', 'کد اموال وارد نشده است');
        }
        if (!$scanner) {
            return $this->alerts(false, 'nullScanner', 'اسکنر انتخاب نشده است');
        }

        $newscanner = new EquipmentedScanner();
        $newscanner->person_id = $personID;
        $newscanner->property_number = $property_number;
        $newscanner->delivery_date = $delivery_date;
        $newscanner->scanner_id = $scanner;
        $newscanner->save();
        $this->logActivity('Equipmented Scanner Added =>' . $newscanner->id, \request()->ip(), \request()->userAgent(), \session('id'));

        $person = Person::find($personID);
        $this->logEquipmentChanges('Equipment Added', $newscanner->id, 'scanner', $property_number, \session('id'), $personID);
        $this->logEquipmentChanges('Assigned to this user => ' . $person->personnel_code, $newscanner->id, 'scanner', $property_number, \session('id'), $personID);
        return $this->success(true, 'scannerAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function newCopyMachine(Request $request)
    {
        $personID = $request->input('person');
        if (!$this->checkAccessingPerson($personID)) {
            return $this->alerts(false, 'wrongPerson', 'access denied');
        }

        $property_number = $request->input('property_number');
        if ($this->checkPropertyNumber($property_number,'copy machine')) {
            return $this->alerts(false, 'duplicatePropertyNumber', 'کد اموال تکراری وارد شده است');
        }

        $delivery_date = $request->input('delivery_date');
        $copymachine = $request->input('copymachine');

        if (!$personID) {
            return $this->alerts(false, 'nullPersonnelCode', 'کد پرسنلی وارد نشده است');
        }
        if (!$property_number) {
            return $this->alerts(false, 'nullPropertyNumber', 'کد اموال وارد نشده است');
        }
        if (!$copymachine) {
            return $this->alerts(false, 'nullCopyMachine', 'اسکنر انتخاب نشده است');
        }

        $newcopymachine = new EquipmentedCopyMachine();
        $newcopymachine->person_id = $personID;
        $newcopymachine->property_number = $property_number;
        $newcopymachine->delivery_date = $delivery_date;
        $newcopymachine->copy_machine_id = $copymachine;
        $newcopymachine->save();
        $this->logActivity('Equipmented Copy Machine Added =>' . $newcopymachine->id, \request()->ip(), \request()->userAgent(), \session('id'));

        $person = Person::find($personID);
        $this->logEquipmentChanges('Equipment Added', $newcopymachine->id, 'copy machine', $property_number, \session('id'), $personID);
        $this->logEquipmentChanges('Assigned to this user => ' . $person->personnel_code, $newcopymachine->id, 'copy machine', $property_number, \session('id'), $personID);
        return $this->success(true, 'copymachineAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function newVOIP(Request $request)
    {
        $personID = $request->input('person');
        if (!$this->checkAccessingPerson($personID)) {
            return $this->alerts(false, 'wrongPerson', 'access denied');
        }

        $property_number = $request->input('property_number');
        if ($this->checkPropertyNumber($property_number,'voip')) {
            return $this->alerts(false, 'duplicatePropertyNumber', 'کد اموال تکراری وارد شده است');
        }

        $delivery_date = $request->input('delivery_date');
        $VOIP = $request->input('VOIP');

        if (!$personID) {
            return $this->alerts(false, 'nullPersonnelCode', 'کد پرسنلی وارد نشده است');
        }
        if (!$property_number) {
            return $this->alerts(false, 'nullPropertyNumber', 'کد اموال وارد نشده است');
        }
        if (!$VOIP) {
            return $this->alerts(false, 'nullVOIP', 'VOIP انتخاب نشده است');
        }

        $newVOIP = new EquipmentedVOIP();
        $newVOIP->person_id = $personID;
        $newVOIP->property_number = $property_number;
        $newVOIP->delivery_date = $delivery_date;
        $newVOIP->VOIP_id = $VOIP;
        $newVOIP->save();
        $this->logActivity('Equipmented VOIP Added =>' . $newVOIP->id, \request()->ip(), \request()->userAgent(), \session('id'));

        $person = Person::find($personID);
        $this->logEquipmentChanges('Equipment Added', $newVOIP->id, 'voip', $property_number, \session('id'), $personID);
        $this->logEquipmentChanges('Assigned to this user => ' . $person->personnel_code, $newVOIP->id, 'voip', $property_number, \session('id'), $personID);
        return $this->success(true, 'VOIPAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function newSwitch(Request $request)
    {
        $personID = $request->input('person');
        if (!$this->checkAccessingPerson($personID)) {
            return $this->alerts(false, 'wrongPerson', 'access denied');
        }

        $property_number = $request->input('property_number');
        if ($this->checkPropertyNumber($property_number,'switch')) {
            return $this->alerts(false, 'duplicatePropertyNumber', 'کد اموال تکراری وارد شده است');
        }

        $delivery_date = $request->input('delivery_date');
        $switch = $request->input('switch');

        if (!$personID) {
            return $this->alerts(false, 'nullPersonnelCode', 'کد پرسنلی وارد نشده است');
        }
        if (!$property_number) {
            return $this->alerts(false, 'nullPropertyNumber', 'کد اموال وارد نشده است');
        }
        if (!$switch) {
            return $this->alerts(false, 'nullSwitch', 'سوییچ انتخاب نشده است');
        }

        $newswitch = new EquipmentedSwitch();
        $newswitch->person_id = $personID;
        $newswitch->property_number = $property_number;
        $newswitch->delivery_date = $delivery_date;
        $newswitch->switch_id = $switch;
        $newswitch->save();
        $this->logActivity('Equipmented Switch Added =>' . $newswitch->id, \request()->ip(), \request()->userAgent(), \session('id'));

        $person = Person::find($personID);
        $this->logEquipmentChanges('Equipment Added', $newswitch->id, 'switch', $property_number, \session('id'), $personID);
        $this->logEquipmentChanges('Assigned to this user => ' . $person->personnel_code, $newswitch->id, 'switch', $property_number, \session('id'), $personID);
        return $this->success(true, 'switchAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function newModem(Request $request)
    {
        $personID = $request->input('person');
        if (!$this->checkAccessingPerson($personID)) {
            return $this->alerts(false, 'wrongPerson', 'access denied');
        }

        $property_number = $request->input('property_number');
        if ($this->checkPropertyNumber($property_number,'modem')) {
            return $this->alerts(false, 'duplicatePropertyNumber', 'کد اموال تکراری وارد شده است');
        }

        $delivery_date = $request->input('delivery_date');
        $modem = $request->input('modem');

        if (!$personID) {
            return $this->alerts(false, 'nullPersonnelCode', 'کد پرسنلی وارد نشده است');
        }
        if (!$property_number) {
            return $this->alerts(false, 'nullPropertyNumber', 'کد اموال وارد نشده است');
        }
        if (!$modem) {
            return $this->alerts(false, 'nullModem', 'مودم انتخاب نشده است');
        }

        $newModem = new EquipmentedModem();
        $newModem->person_id = $personID;
        $newModem->property_number = $property_number;
        $newModem->delivery_date = $delivery_date;
        $newModem->modem_id = $modem;
        $newModem->save();
        $this->logActivity('Equipmented Modem Added =>' . $newModem->id, \request()->ip(), \request()->userAgent(), \session('id'));

        $person = Person::find($personID);
        $this->logEquipmentChanges('Equipment Added', $newModem->id, 'modem', $property_number, \session('id'), $personID);
        $this->logEquipmentChanges('Assigned to this user => ' . $person->personnel_code, $newModem->id, 'modem', $property_number, \session('id'), $personID);
        return $this->success(true, 'modemAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function newLaptop(Request $request)
    {
        $personID = $request->input('person');
        if (!$this->checkAccessingPerson($personID)) {
            return $this->alerts(false, 'wrongPerson', 'access denied');
        }

        $property_number = $request->input('property_number');
        if ($this->checkPropertyNumber($property_number,'laptop')) {
            return $this->alerts(false, 'duplicatePropertyNumber', 'کد اموال تکراری وارد شده است');
        }

        $delivery_date = $request->input('delivery_date');
        $modem = $request->input('modem');

        if (!$personID) {
            return $this->alerts(false, 'nullPersonnelCode', 'کد پرسنلی وارد نشده است');
        }
        if (!$property_number) {
            return $this->alerts(false, 'nullPropertyNumber', 'کد اموال وارد نشده است');
        }
        if (!$modem) {
            return $this->alerts(false, 'nullModem', 'مودم انتخاب نشده است');
        }

        $newLaptop = new EquipmentedModem();
        $newLaptop->person_id = $personID;
        $newLaptop->property_number = $property_number;
        $newLaptop->delivery_date = $delivery_date;
        $newLaptop->modem_id = $modem;
        $newLaptop->save();
        $this->logActivity('Equipmented Modem Added =>' . $newLaptop->id, \request()->ip(), \request()->userAgent(), \session('id'));

        $person = Person::find($personID);
        $this->logEquipmentChanges('Equipment Added', $newLaptop->id, 'laptop', $property_number, \session('id'), $personID);
        $this->logEquipmentChanges('Assigned to this user => ' . $person->personnel_code, $newLaptop->id, 'laptop', $property_number, \session('id'), $personID);
        return $this->success(true, 'modemAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function newMobile(Request $request)
    {
        $personID = $request->input('person');
        if (!$this->checkAccessingPerson($personID)) {
            return $this->alerts(false, 'wrongPerson', 'access denied');
        }

        $property_number = $request->input('property_number');
        if ($this->checkPropertyNumber($property_number,'mobile')) {
            return $this->alerts(false, 'duplicatePropertyNumber', 'کد اموال تکراری وارد شده است');
        }

        $delivery_date = $request->input('delivery_date');
        $mobile = $request->input('mobile');

        if (!$personID) {
            return $this->alerts(false, 'nullPersonnelCode', 'کد پرسنلی وارد نشده است');
        }
        if (!$property_number) {
            return $this->alerts(false, 'nullPropertyNumber', 'کد اموال وارد نشده است');
        }
        if (!$mobile) {
            return $this->alerts(false, 'nullMobile', 'موبایل انتخاب نشده است');
        }

        $newMobile = new EquipmentedMobile();
        $newMobile->person_id = $personID;
        $newMobile->property_number = $property_number;
        $newMobile->delivery_date = $delivery_date;
        $newMobile->mobile_id = $mobile;
        $newMobile->save();
        $this->logActivity('Equipmented Mobile Added =>' . $newMobile->id, \request()->ip(), \request()->userAgent(), \session('id'));

        $person = Person::find($personID);
        $this->logEquipmentChanges('Equipment Added', $newMobile->id, 'mobile', $property_number, \session('id'), $personID);
        $this->logEquipmentChanges('Assigned to this user => ' . $person->personnel_code, $newMobile->id, 'mobile', $property_number, \session('id'), $personID);
        return $this->success(true, 'mobileAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function newTablet(Request $request)
    {
        $personID = $request->input('person');
        if (!$this->checkAccessingPerson($personID)) {
            return $this->alerts(false, 'wrongPerson', 'access denied');
        }

        $property_number = $request->input('property_number');
        if ($this->checkPropertyNumber($property_number,'tablet')) {
            return $this->alerts(false, 'duplicatePropertyNumber', 'کد اموال تکراری وارد شده است');
        }

        $delivery_date = $request->input('delivery_date');
        $tablet = $request->input('tablet');

        if (!$personID) {
            return $this->alerts(false, 'nullPersonnelCode', 'کد پرسنلی وارد نشده است');
        }
        if (!$property_number) {
            return $this->alerts(false, 'nullPropertyNumber', 'کد اموال وارد نشده است');
        }
        if (!$tablet) {
            return $this->alerts(false, 'nullTablet', 'موبایل انتخاب نشده است');
        }

        $newTablet = new EquipmentedTablet();
        $newTablet->person_id = $personID;
        $newTablet->property_number = $property_number;
        $newTablet->delivery_date = $delivery_date;
        $newTablet->tablet_id = $tablet;
        $newTablet->save();
        $this->logActivity('Equipmented Tablet Added =>' . $newTablet->id, \request()->ip(), \request()->userAgent(), \session('id'));

        $person = Person::find($personID);
        $this->logEquipmentChanges('Equipment Added', $newTablet->id, 'tablet', $property_number, \session('id'), $personID);
        $this->logEquipmentChanges('Assigned to this user => ' . $person->personnel_code, $newTablet->id, 'tablet', $property_number, \session('id'), $personID);
        return $this->success(true, 'tabletAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function newWebcam(Request $request)
    {
        $personID = $request->input('person');
        if (!$this->checkAccessingPerson($personID)) {
            return $this->alerts(false, 'wrongPerson', 'access denied');
        }

        $property_number = $request->input('property_number');
        if ($this->checkPropertyNumber($property_number,'webcam')) {
            return $this->alerts(false, 'duplicatePropertyNumber', 'کد اموال تکراری وارد شده است');
        }

        $delivery_date = $request->input('delivery_date');
        $webcam = $request->input('webcam');

        if (!$personID) {
            return $this->alerts(false, 'nullPersonnelCode', 'کد پرسنلی وارد نشده است');
        }
        if (!$property_number) {
            return $this->alerts(false, 'nullPropertyNumber', 'کد اموال وارد نشده است');
        }
        if (!$webcam) {
            return $this->alerts(false, 'nullWebcam', 'وبکم انتخاب نشده است');
        }

        $newWebcam = new EquipmentedWebcam();
        $newWebcam->person_id = $personID;
        $newWebcam->property_number = $property_number;
        $newWebcam->delivery_date = $delivery_date;
        $newWebcam->webcam_id = $webcam;
        $newWebcam->save();
        $this->logActivity('Equipmented Webcam Added =>' . $newWebcam->id, \request()->ip(), \request()->userAgent(), \session('id'));

        $person = Person::find($personID);
        $this->logEquipmentChanges('Equipment Added', $newWebcam->id, 'webcam', $property_number, \session('id'), $personID);
        $this->logEquipmentChanges('Assigned to this user => ' . $person->personnel_code, $newWebcam->id, 'webcam', $property_number, \session('id'), $personID);
        return $this->success(true, 'webcamAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function newRecorder(Request $request)
    {
        $personID = $request->input('person');
        if (!$this->checkAccessingPerson($personID)) {
            return $this->alerts(false, 'wrongPerson', 'access denied');
        }

        $property_number = $request->input('property_number');
        if ($this->checkPropertyNumber($property_number,'recorder')) {
            return $this->alerts(false, 'duplicatePropertyNumber', 'کد اموال تکراری وارد شده است');
        }

        $delivery_date = $request->input('delivery_date');
        $recorder = $request->input('recorder');

        if (!$personID) {
            return $this->alerts(false, 'nullPersonnelCode', 'کد پرسنلی وارد نشده است');
        }
        if (!$property_number) {
            return $this->alerts(false, 'nullPropertyNumber', 'کد اموال وارد نشده است');
        }
        if (!$recorder) {
            return $this->alerts(false, 'nullRecorder', 'رکوردر انتخاب نشده است');
        }

        $newRecorder = new EquipmentedRecorder();
        $newRecorder->person_id = $personID;
        $newRecorder->property_number = $property_number;
        $newRecorder->delivery_date = $delivery_date;
        $newRecorder->recorder_id = $recorder;
        $newRecorder->save();
        $this->logActivity('Equipmented Recorder Added =>' . $newRecorder->id, \request()->ip(), \request()->userAgent(), \session('id'));

        $person = Person::find($personID);
        $this->logEquipmentChanges('Equipment Added', $newRecorder->id, 'recorder', $property_number, \session('id'), $personID);
        $this->logEquipmentChanges('Assigned to this user => ' . $person->personnel_code, $newRecorder->id, 'recorder', $property_number, \session('id'), $personID);
        return $this->success(true, 'recorderAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function newHeadphone(Request $request)
    {
        $personID = $request->input('person');
        if (!$this->checkAccessingPerson($personID)) {
            return $this->alerts(false, 'wrongPerson', 'access denied');
        }

        $property_number = $request->input('property_number');
        if ($this->checkPropertyNumber($property_number,'headphone')) {
            return $this->alerts(false, 'duplicatePropertyNumber', 'کد اموال تکراری وارد شده است');
        }

        $delivery_date = $request->input('delivery_date');
        $headphone = $request->input('headphone');

        if (!$personID) {
            return $this->alerts(false, 'nullPersonnelCode', 'کد پرسنلی وارد نشده است');
        }
        if (!$property_number) {
            return $this->alerts(false, 'nullPropertyNumber', 'کد اموال وارد نشده است');
        }
        if (!$headphone) {
            return $this->alerts(false, 'nullHeadphone', 'هدفون انتخاب نشده است');
        }

        $newHeadphone = new EquipmentedHeadphone();
        $newHeadphone->person_id = $personID;
        $newHeadphone->property_number = $property_number;
        $newHeadphone->delivery_date = $delivery_date;
        $newHeadphone->headphone_id = $headphone;
        $newHeadphone->save();
        $this->logActivity('Equipmented Headphone Added =>' . $newHeadphone->id, \request()->ip(), \request()->userAgent(), \session('id'));

        $person = Person::find($personID);
        $this->logEquipmentChanges('Equipment Added', $newHeadphone->id, 'headphone', $property_number, \session('id'), $personID);
        $this->logEquipmentChanges('Assigned to this user => ' . $person->personnel_code, $newHeadphone->id, 'headphone', $property_number, \session('id'), $personID);
        return $this->success(true, 'headphoneAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function newSpeaker(Request $request)
    {
        $personID = $request->input('person');
        if (!$this->checkAccessingPerson($personID)) {
            return $this->alerts(false, 'wrongPerson', 'access denied');
        }

        $property_number = $request->input('property_number');
        if ($this->checkPropertyNumber($property_number,'speaker')) {
            return $this->alerts(false, 'duplicatePropertyNumber', 'کد اموال تکراری وارد شده است');
        }

        $delivery_date = $request->input('delivery_date');
        $speaker = $request->input('speaker');

        if (!$personID) {
            return $this->alerts(false, 'nullPersonnelCode', 'کد پرسنلی وارد نشده است');
        }
        if (!$property_number) {
            return $this->alerts(false, 'nullPropertyNumber', 'کد اموال وارد نشده است');
        }
        if (!$speaker) {
            return $this->alerts(false, 'nullSpeaker', 'اسپیکر انتخاب نشده است');
        }

        $newSpeaker = new EquipmentedSpeaker();
        $newSpeaker->person_id = $personID;
        $newSpeaker->property_number = $property_number;
        $newSpeaker->delivery_date = $delivery_date;
        $newSpeaker->speaker_id = $speaker;
        $newSpeaker->save();
        $this->logActivity('Equipmented Speaker Added =>' . $newSpeaker->id, \request()->ip(), \request()->userAgent(), \session('id'));

        $person = Person::find($personID);
        $this->logEquipmentChanges('Equipment Added', $newSpeaker->id, 'speaker', $property_number, \session('id'), $personID);
        $this->logEquipmentChanges('Assigned to this user => ' . $person->personnel_code, $newSpeaker->id, 'speaker', $property_number, \session('id'), $personID);
        return $this->success(true, 'speakerAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function newVideoProjector(Request $request)
    {
        $personID = $request->input('person');
        if (!$this->checkAccessingPerson($personID)) {
            return $this->alerts(false, 'wrongPerson', 'access denied');
        }

        $property_number = $request->input('property_number');
        if ($this->checkPropertyNumber($property_number,'video projector')) {
            return $this->alerts(false, 'duplicatePropertyNumber', 'کد اموال تکراری وارد شده است');
        }

        $delivery_date = $request->input('delivery_date');
        $videoprojector = $request->input('videoprojector');

        if (!$personID) {
            return $this->alerts(false, 'nullPersonnelCode', 'کد پرسنلی وارد نشده است');
        }
        if (!$property_number) {
            return $this->alerts(false, 'nullPropertyNumber', 'کد اموال وارد نشده است');
        }
        if (!$videoprojector) {
            return $this->alerts(false, 'nullVideoProjector', 'ویدئو پروژکتور انتخاب نشده است');
        }

        $newVideoProjector = new EquipmentedVideoProjector();
        $newVideoProjector->person_id = $personID;
        $newVideoProjector->property_number = $property_number;
        $newVideoProjector->delivery_date = $delivery_date;
        $newVideoProjector->video_projector_id = $videoprojector;
        $newVideoProjector->save();
        $this->logActivity('Equipmented Video Projector Added =>' . $newVideoProjector->id, \request()->ip(), \request()->userAgent(), \session('id'));

        $person = Person::find($personID);
        $this->logEquipmentChanges('Equipment Added', $newVideoProjector->id, 'video projector', $property_number, \session('id'), $personID);
        $this->logEquipmentChanges('Assigned to this user => ' . $person->personnel_code, $newVideoProjector->id, 'video projector', $property_number, \session('id'), $personID);
        return $this->success(true, 'videoProjectorAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function newVideoProjectorCurtain(Request $request)
    {
        $personID = $request->input('person');
        if (!$this->checkAccessingPerson($personID)) {
            return $this->alerts(false, 'wrongPerson', 'access denied');
        }

        $property_number = $request->input('property_number');
        if ($this->checkPropertyNumber($property_number,'video projector curtain')) {
            return $this->alerts(false, 'duplicatePropertyNumber', 'کد اموال تکراری وارد شده است');
        }

        $delivery_date = $request->input('delivery_date');
        $videoprojectorcurtain = $request->input('videoprojectorcurtain');

        if (!$personID) {
            return $this->alerts(false, 'nullPersonnelCode', 'کد پرسنلی وارد نشده است');
        }
        if (!$property_number) {
            return $this->alerts(false, 'nullPropertyNumber', 'کد اموال وارد نشده است');
        }
        if (!$videoprojectorcurtain) {
            return $this->alerts(false, 'nullVideoProjectorCurtain', 'پرده ویدئو پروژکتور انتخاب نشده است');
        }

        $newVideoProjectorCurtain = new EquipmentedVideoProjectorCurtain();
        $newVideoProjectorCurtain->person_id = $personID;
        $newVideoProjectorCurtain->property_number = $property_number;
        $newVideoProjectorCurtain->delivery_date = $delivery_date;
        $newVideoProjectorCurtain->vp_curtain_id = $videoprojectorcurtain;
        $newVideoProjectorCurtain->save();
        $this->logActivity('Equipmented Video Projector Curtain Added =>' . $newVideoProjectorCurtain->id, \request()->ip(), \request()->userAgent(), \session('id'));

        $person = Person::find($personID);
        $this->logEquipmentChanges('Equipment Added', $newVideoProjectorCurtain->id, 'video projector curtain', $property_number, \session('id'), $personID);
        $this->logEquipmentChanges('Assigned to this user => ' . $person->personnel_code, $newVideoProjectorCurtain->id, 'video projector curtain', $property_number, \session('id'), $personID);
        return $this->success(true, 'videoProjectorCurtainAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function getEquipmentInfo(Request $request)
    {
        $id = $request->input('id');
        if ($id) {
            switch ($request->input('type')) {
                case 'case':
                    $equipmentInfo = EquipmentedCase::find($id);
                    break;
                case 'copy_machine':
                    $equipmentInfo = EquipmentedCopyMachine::find($id);
                    break;
                case 'monitor':
                    $equipmentInfo = EquipmentedMonitor::find($id);
                    break;
                case 'printer':
                    $equipmentInfo = EquipmentedPrinter::find($id);
                    break;
                case 'scanner':
                    $equipmentInfo = EquipmentedScanner::find($id);
                    break;
                case 'voip':
                    $equipmentInfo = EquipmentedVoip::find($id);
                    break;
                case 'modem':
                    $equipmentInfo = EquipmentedModem::find($id);
                    break;
                case 'switch':
                    $equipmentInfo = EquipmentedSwitch::find($id);
                    break;
                case 'headphone':
                    $equipmentInfo = EquipmentedHeadphone::find($id);
                    break;
                case 'laptop':
                    $equipmentInfo = EquipmentedLaptop::find($id);
                    break;
                case 'mobile':
                    $equipmentInfo = EquipmentedMobile::find($id);
                    break;
                case 'recorder':
                    $equipmentInfo = EquipmentedRecorder::find($id);
                    break;
                case 'speaker':
                    $equipmentInfo = EquipmentedSpeaker::find($id);
                    break;
                case 'tablet':
                    $equipmentInfo = EquipmentedTablet::find($id);
                    break;
                case 'videoprojector':
                    $equipmentInfo = EquipmentedVideoProjector::find($id);
                    break;
                case 'videoprojectorcurtain':
                    $equipmentInfo = EquipmentedVideoProjectorCurtain::find($id);
                    break;
                case 'webcam':
                    $equipmentInfo = EquipmentedWebcam::find($id);
                    break;
            }
            return $equipmentInfo;

        }
    }
}
