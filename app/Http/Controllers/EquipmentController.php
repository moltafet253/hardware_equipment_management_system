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
use App\Models\EquipmentedOtherDevices\EquipmentedMobile;
use App\Models\EquipmentedOtherDevices\EquipmentedRecorder;
use App\Models\EquipmentedOtherDevices\EquipmentedSpeaker;
use App\Models\EquipmentedOtherDevices\EquipmentedVideoProjector;
use App\Models\EquipmentedOtherDevices\EquipmentedVideoProjectorCurtain;
use App\Models\EquipmentedOtherDevices\EquipmentedWebcam;
use App\Models\EquipmentedPrinter;
use App\Models\EquipmentedScanner;
use App\Models\EquipmentedVoip;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function showEquipmentStatus(Request $request)
    {
        $personId = $request->input('id');
        return view('EquipmentStatus', ['personId' => $personId]);
    }

    public function newCase(Request $request)
    {
        $personID = $request->input('person');
        $property_number = $request->input('property_number');
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
        $graphiccard = $request->input('graphiccard');
        $networkcard = $request->input('networkcard');

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
        if (!$graphiccard) {
            $graphiccard = 1;
        }
        if (!$networkcard) {
            $networkcard = 1;
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
        $case->ram3 = $ram3;
        $case->ram4 = $ram4;
        $case->hdd1 = $hdd1;
        $case->hdd2 = $hdd2;
        $case->graphic_card = $graphiccard;
        $case->network_card = $networkcard;
        $case->save();
        $this->logActivity('Case Added =>' . $case->id, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'caseAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');

    }

    public function newMonitor(Request $request)
    {
        $personID = $request->input('person');
        $property_number = $request->input('property_number');
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
        $this->logActivity('Monitor Added =>' . $newmonitor->id, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'monitorAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');

    }

    public function newPrinter(Request $request)
    {
        $personID = $request->input('person');
        $property_number = $request->input('property_number');
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
        $this->logActivity('Printer Added =>' . $newprinter->id, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'printerAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function newScanner(Request $request)
    {
        $personID = $request->input('person');
        $property_number = $request->input('property_number');
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
        $this->logActivity('Scanner Added =>' . $newscanner->id, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'scannerAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function newCopyMachine(Request $request)
    {
        $personID = $request->input('person');
        $property_number = $request->input('property_number');
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
        $this->logActivity('Copy Machine Added =>' . $newcopymachine->id, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'copymachineAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function newVOIP(Request $request)
    {
        $personID = $request->input('person');
        $property_number = $request->input('property_number');
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
        $this->logActivity('VOIP Added =>' . $newVOIP->id, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'VOIPAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function newSwitch(Request $request)
    {
        $personID = $request->input('person');
        $property_number = $request->input('property_number');
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
        $this->logActivity('Switch Added =>' . $newswitch->id, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'switchAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function newModem(Request $request)
    {
        $personID = $request->input('person');
        $property_number = $request->input('property_number');
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
        $this->logActivity('Modem Added =>' . $newModem->id, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'modemAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function newLaptop(Request $request)
    {
        $personID = $request->input('person');
        $property_number = $request->input('property_number');
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

        $newmodem = new EquipmentedModem();
        $newmodem->person_id = $personID;
        $newmodem->property_number = $property_number;
        $newmodem->delivery_date = $delivery_date;
        $newmodem->modem_id = $modem;
        $newmodem->save();
        $this->logActivity('Modem Added =>' . $newmodem->id, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'modemAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function newMobile(Request $request)
    {
        $personID = $request->input('person');
        $property_number = $request->input('property_number');
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

        $newmodem = new EquipmentedMobile();
        $newmodem->person_id = $personID;
        $newmodem->property_number = $property_number;
        $newmodem->delivery_date = $delivery_date;
        $newmodem->mobile_id = $mobile;
        $newmodem->save();
        $this->logActivity('Mobile Added =>' . $newmodem->id, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'mobileAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function newTablet(Request $request)
    {
        $personID = $request->input('person');
        $property_number = $request->input('property_number');
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

        $newmodem = new EquipmentedModem();
        $newmodem->person_id = $personID;
        $newmodem->property_number = $property_number;
        $newmodem->delivery_date = $delivery_date;
        $newmodem->modem_id = $modem;
        $newmodem->save();
        $this->logActivity('Modem Added =>' . $newmodem->id, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'modemAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function newWebcam(Request $request)
    {
        $personID = $request->input('person');
        $property_number = $request->input('property_number');
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
        $this->logActivity('Webcam Added =>' . $newWebcam->id, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'webcamAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function newRecorder(Request $request)
    {
        $personID = $request->input('person');
        $property_number = $request->input('property_number');
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
        $this->logActivity('Recorder Added =>' . $newRecorder->id, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'recorderAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function newHeadphone(Request $request)
    {
        $personID = $request->input('person');
        $property_number = $request->input('property_number');
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
        $this->logActivity('Headphone Added =>' . $newHeadphone->id, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'headphoneAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function newSpeaker(Request $request)
    {
        $personID = $request->input('person');
        $property_number = $request->input('property_number');
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
        $this->logActivity('Speaker Added =>' . $newSpeaker->id, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'speakerAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function newVideoProjector(Request $request)
    {
        $personID = $request->input('person');
        $property_number = $request->input('property_number');
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
        $this->logActivity('Video Projector Added =>' . $newVideoProjector->id, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'videoProjectorAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function newVideoProjectorCurtain(Request $request)
    {
        $personID = $request->input('person');
        $property_number = $request->input('property_number');
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
        $this->logActivity('Video Projector Curtain Added =>' . $newVideoProjectorCurtain->id, \request()->ip(), \request()->userAgent(), \session('id'));
        return $this->success(true, 'videoProjectorCurtainAdded', 'برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.');
    }

    public function newComment(Request $request)
    {
        $request->all();
        $personID = $request->input('person');
        $title = $request->input('title');
        $ticket_number = $request->input('ticket_number');
        $jobs = $request->input('jobs');
        $description = $request->input('description');
        $jobNames = null;

        if (!$personID) {
            return $this->alerts(false, 'nullPersonnelCode', 'کد پرسنلی وارد نشده است');
        }
        if (!$title) {
            return $this->alerts(false, 'nullPersonnelCode', 'موضوع وارد نشده است');
        }
        if (!$description) {
            return $this->alerts(false, 'nullDescription', 'توضیحات وارد نشده است');
        }

        $newComment = new Comment();
        $newComment->person_id = $personID;
        $newComment->title = $title;
        $newComment->ticket_number = $ticket_number;
        if ($jobs) {
            $newComment->jobs = json_encode($jobs);
            $jobsArray = json_decode($newComment->jobs);
            $jobNames = Job::whereIn('id', $jobsArray)->pluck('title')->toArray();
            $jobNames = implode(' | ', $jobNames);
        }
        $newComment->description = $description;
        $newComment->save();
        $this->logActivity('Comment Added =>' . $newComment->id, \request()->ip(), \request()->userAgent(), \session('id'));

        $newRowHtml = '<tr class="even:bg-gray-300 odd:bg-white">' .
            '<td class=" px-3 py-3 ">' . $title . '</td>' .
            '<td class=" px-3 py-3 ">' . $jobNames . '</td>' .
            '<td class=" px-3 py-3 ">' . $description . '</td>' .
            '<td class=" px-3 py-3 "><button class="px-4 py-2 mr-3 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300 EditComment" type="submit">ویرایش</button></td>' .
            '</tr>';
        return response()->json([
            'success' => true,
            'message' => 'کامنت با موفقیت اضافه شد. برای نمایش اطلاعات جدید، لطفا صفحه را رفرش نمایید.',
            'html' => $newRowHtml
        ]);
    }

}
