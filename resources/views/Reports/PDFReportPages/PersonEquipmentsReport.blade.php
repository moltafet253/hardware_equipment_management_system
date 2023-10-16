@php use App\Models\Catalogs\Cases;
 use App\Models\Catalogs\cpu;
 use App\Models\Catalogs\GraphicCard;
 use App\Models\Catalogs\Harddisk;
 use App\Models\Catalogs\Motherboard;
 use App\Models\Catalogs\NetworkCard;
 use App\Models\Catalogs\NetworkEquipments\Modem;
 use App\Models\Catalogs\NetworkEquipments\Switches;
 use App\Models\Catalogs\Odd;
 use App\Models\Catalogs\OtherEquipments\Headphone;use App\Models\Catalogs\OtherEquipments\Mobile;
 use App\Models\Catalogs\OtherEquipments\Recorder;use App\Models\Catalogs\OtherEquipments\Speaker;use App\Models\Catalogs\OtherEquipments\Tablet;
 use App\Models\Catalogs\OtherEquipments\VideoProjector;use App\Models\Catalogs\OtherEquipments\Webcam;use App\Models\Catalogs\Power;
 use App\Models\Catalogs\Ram;
 use App\Models\EquipmentedCase;
 use App\Models\EquipmentedNetworkDevices\EquipmentedModem;
 use App\Models\EquipmentedNetworkDevices\EquipmentedSwitch;
 use App\Models\EquipmentedOtherDevices\EquipmentedHeadphone;
 use App\Models\EquipmentedOtherDevices\EquipmentedMobile;
 use App\Models\EquipmentedOtherDevices\EquipmentedRecorder;use App\Models\EquipmentedOtherDevices\EquipmentedSpeaker;use App\Models\EquipmentedOtherDevices\EquipmentedTablet;
 use App\Models\EquipmentedOtherDevices\EquipmentedVideoProjector;use App\Models\EquipmentedOtherDevices\EquipmentedWebcam;use App\Models\EquipmentedVoip;
@endphp
    <!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>اطلاعات تجهیزات پرسنل</title>
    <style type="text/css">
        body {
            font-family: 'vazir', serif;
            direction: rtl;
        }

        @page {
            header: page-header;
            footer: page-footer;
            size: 8.5in 11in;
            /* <length>{1,2} | auto | portrait | landscape */
            /* 'em' 'ex' and % are not allowed; length values are width height */
            margin: 10% 5% 5% 5%;
            /* <any of the usual CSS values for margins> */
            /*(% of page-box width for LR, of height for TB) */
            margin-header: 5mm;
            /* <any of the usual CSS values for margins> */
            margin-footer: 5mm;
            /* <any of the usual CSS values for margins> */
        }

        .logo {
            width: 2cm;
            height: 2cm;
        }

        table.GeneratedTable {
            width: 100%;
            background-color: #ffffff;
            border-collapse: collapse;
            border-width: 2px;
            border-color: #ffcc00;
            border-style: solid;
            color: #000000;
        }

        table.GeneratedTable td, table.GeneratedTable th {
            border-width: 2px;
            border-color: #ffcc00;
            border-style: solid;
            padding: 3px;
        }

        table.GeneratedTable thead {
            background-color: #ffcc00;
        }
    </style>
</head>
<body>

<div>
    <h2 style="text-align: center">
        تجهیزات پرسنل
        {{ $personInfo->name . ' ' . $personInfo->family  . ' با کد ' . $personInfo->personnel_code . ' و کد ملی: ' . $personInfo->national_code}}
    </h2>

    {{--    cases--}}
    <div style="text-align: center">
        <table class="GeneratedTable">
            <thead>
            <tr style="background-color:#ffcc00">
                <th colspan="5">کیس های ثبت شده</th>
            </tr>
            <tr>
                <th style="width:7%">ردیف</th>
                <th style="width:10%">کد اموال</th>
                <th style="width:10%">کد پلمپ</th>
                <th style="width:15%">تاریخ تحویل</th>
                <th>مشخصات</th>
            </tr>
            </thead>
            <tbody>
            @php
                $cases=EquipmentedCase::where('person_id',$personInfo->id)->get();
            @endphp
            @foreach($cases as $key=>$case)
                <tr>
                    <td style="text-align: center">{{ ++$key }}</td>
                    <td style="text-align: center">{{ $case->property_number }}</td>
                    <td style="text-align: center">{{ $case->stamp_number }}</td>
                    <td style="text-align: center">{{ $case->delivery_date }}</td>
                    <td>
                        @php
                            $caseInfo = Cases::with('company')->find($case->case);
                            echo 'کیس: ' . $caseInfo->company->name . ' ' . $caseInfo->model . '<br>';

                            $motherboardInfo=Motherboard::with('company')->find($case->motherboard);
                            echo 'مادربورد: ' . $motherboardInfo->company->name . ' ' . $motherboardInfo->model . '<br>';

                            $powerInfo=Power::with('company')->find($case->power);
                            echo 'منبع تغذیه: ' . $powerInfo->company->name . ' ' . $powerInfo->model . ' ' . $powerInfo->output_voltage . '<br>';

                            $cpuInfo=cpu::with('company')->find($case->cpu);
                            echo 'پردازنده: ' . $cpuInfo->company->name . ' ' . $cpuInfo->model . '<br>';

                            if ($case->ram1){
                            $ram1Info=Ram::with('company')->find($case->ram1);
                            echo 'رم 1: ' . $ram1Info->company->name . ' ' . $ram1Info->model . ' ' . $ram1Info->type . ' ' . $ram1Info->size . ' ' . $ram1Info->frequency . '<br>';
                            }

                            if ($case->ram2){
                            $ram2Info=Ram::with('company')->find($case->ram2);
                            echo 'رم 2: ' . $ram2Info->company->name . ' ' . $ram2Info->model . ' ' . $ram2Info->type . ' ' . $ram2Info->size . ' ' . $ram2Info->frequency . '<br>';
                            }

                            if ($case->ram3){
                            $ram3Info=Ram::with('company')->find($case->ram3);
                            echo 'رم 3: ' . $ram3Info->company->name . ' ' . $ram3Info->model . ' ' . $ram3Info->type . ' ' . $ram3Info->size . ' ' . $ram3Info->frequency . '<br>';
                            }

                            if ($case->ram4){
                            $ram4Info=Ram::with('company')->find($case->ram4);
                            echo 'رم 4: ' . $ram4Info->company->name . ' ' . $ram4Info->model . ' ' . $ram4Info->type . ' ' . $ram4Info->size . ' ' . $ram4Info->frequency . '<br>';
                            }

                            if ($case->hdd1){
                            $hdd1Info=Harddisk::with('company')->find($case->hdd1);
                            echo 'هارد 1: ' . $hdd1Info->company->name . ' ' . $hdd1Info->model . ' ' . $hdd1Info->capacity . '<br>';
                            }

                            if ($case->hdd2){
                            $hdd2Info=Harddisk::with('company')->find($case->hdd2);
                            echo 'هارد 2: ' . $hdd2Info->company->name . ' ' . $hdd2Info->model . ' ' . $hdd2Info->capacity . '<br>';
                            }

                            if ($case->hdd3){
                            $hdd3Info=Harddisk::with('company')->find($case->hdd3);
                            echo 'هارد 3: ' . $hdd3Info->company->name . ' ' . $hdd3Info->model . ' ' . $hdd3Info->capacity . '<br>';
                            }

                            if ($case->hdd4){
                            $hdd4Info=Harddisk::with('company')->find($case->hdd4);
                            echo 'هارد 4: ' . $hdd4Info->company->name . ' ' . $hdd4Info->model . ' ' . $hdd4Info->capacity . '<br>';
                            }

                            $graphicCardInfo=GraphicCard::with('company')->find($case->graphic_card);
                            if ($graphicCardInfo){
                            echo 'کارت گرافیک: ' . $graphicCardInfo->company->name . ' ' . $graphicCardInfo->model . '<br>';
                            }

                            $oddInfo=Odd::with('company')->find($case->odd);
                            if ($oddInfo){
                            echo 'درایو نوری: ' . $oddInfo->company->name . ' ' . $oddInfo->model . '<br>';
                            }

                            $networkCardInfo=NetworkCard::with('company')->find($case->network_card);
                            if ($networkCardInfo){
                            echo 'کارت شبکه: ' . $networkCardInfo->company->name . ' ' . $networkCardInfo->model . '<br>';
                            }

                        @endphp

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    {{--    monitors--}}
    <div style="text-align: center; margin-top: 20px">
        <table class="GeneratedTable">
            <thead>
            <tr style="background-color:#ffcc00">
                <th colspan="4">مانیتور های ثبت شده</th>
            </tr>
            <tr>
                <th style="width:7%">ردیف</th>
                <th style="width:10%">کد اموال</th>
                <th style="width:15%">تاریخ تحویل</th>
                <th>مشخصات</th>
            </tr>
            </thead>
            <tbody>
            @php
                $monitors=\App\Models\EquipmentedMonitor::where('person_id',$personInfo->id)->get();
            @endphp
            @foreach($monitors as $key=>$monitor)
                <tr>
                    <td style="text-align: center">{{ ++$key }}</td>
                    <td style="text-align: center">{{ $monitor->property_number }}</td>
                    <td style="text-align: center">{{ $monitor->delivery_date }}</td>
                    <td style="text-align: center">
                        @php
                            $monitorInfo = \App\Models\Catalogs\Monitor::with('company')->find($monitor->monitor_id);
                            echo $monitorInfo->company->name . ' ' . $monitorInfo->model . ' ' . $monitorInfo->size . 'inch <br>';
                        @endphp
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    {{--    printers--}}
    <div style="text-align: center; margin-top: 20px">
        <table class="GeneratedTable">
            <thead>
            <tr style="background-color:#ffcc00">
                <th colspan="5">پرینترهای ثبت شده</th>
            </tr>
            <tr>
                <th style="width:7%">ردیف</th>
                <th style="width:10%">کد اموال</th>
                <th style="width:15%">تاریخ تحویل</th>
                <th>مشخصات</th>
                <th>نوع</th>
            </tr>
            </thead>
            <tbody>
            @php
                $printers=\App\Models\EquipmentedPrinter::where('person_id',$personInfo->id)->get();
            @endphp
            @foreach($printers as $key=>$printer)
                <tr>
                    <td style="text-align: center">{{ ++$key }}</td>
                    <td style="text-align: center">{{ $printer->property_number }}</td>
                    <td style="text-align: center">{{ $printer->delivery_date }}</td>
                    <td style="text-align: center">
                        @php
                            $printerInfo = \App\Models\Catalogs\Printer::with('company')->find($printer->printer_id);
                            echo $printerInfo->company->name . ' ' . $printerInfo->model . '<br>';
                        @endphp
                    </td>
                    <td style="text-align: center">{{ $printerInfo->function_type }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    {{--    scanners--}}
    <div style="text-align: center; margin-top: 20px">
        <table class="GeneratedTable">
            <thead>
            <tr style="background-color:#ffcc00">
                <th colspan="4">اسکنرهای ثبت شده</th>
            </tr>
            <tr>
                <th style="width:7%">ردیف</th>
                <th style="width:10%">کد اموال</th>
                <th style="width:15%">تاریخ تحویل</th>
                <th>مشخصات</th>
            </tr>
            </thead>
            <tbody>
            @php
                $scanners=\App\Models\EquipmentedScanner::where('person_id',$personInfo->id)->get();
            @endphp
            @foreach($scanners as $key=>$scanner)
                <tr>
                    <td style="text-align: center">{{ ++$key }}</td>
                    <td style="text-align: center">{{ $scanner->property_number }}</td>
                    <td style="text-align: center">{{ $scanner->delivery_date }}</td>
                    <td style="text-align: center">
                        @php
                            $scannerInfo = \App\Models\Catalogs\Printer::with('company')->find($scanner->scanner_id);
                            echo $scannerInfo->company->name . ' ' . $scannerInfo->model . '<br>';
                        @endphp
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    {{--    copy machines--}}
    <div style="text-align: center; margin-top: 20px">
        <table class="GeneratedTable">
            <thead>
            <tr style="background-color:#ffcc00">
                <th colspan="4">دستگاه کپی های ثبت شده</th>
            </tr>
            <tr>
                <th style="width:7%">ردیف</th>
                <th style="width:10%">کد اموال</th>
                <th style="width:15%">تاریخ تحویل</th>
                <th>مشخصات</th>
            </tr>
            </thead>
            <tbody>
            @php
                $copymachines=\App\Models\EquipmentedCopyMachine::where('person_id',$personInfo->id)->get();
            @endphp
            @foreach($copymachines as $key=>$copymachine)
                <tr>
                    <td style="text-align: center">{{ ++$key }}</td>
                    <td style="text-align: center">{{ $copymachine->property_number }}</td>
                    <td style="text-align: center">{{ $copymachine->delivery_date }}</td>
                    <td style="text-align: center">
                        @php
                            $copymachineInfo = \App\Models\Catalogs\CopyMachine::with('company')->find($copymachine->copy_machine_id);
                            echo $copymachineInfo->company->name . ' ' . $copymachineInfo->model . '<br>';
                        @endphp
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    {{--    voips--}}
    <div style="text-align: center; margin-top: 20px">
        <table class="GeneratedTable">
            <thead>
            <tr style="background-color:#ffcc00">
                <th colspan="4">voip های ثبت شده</th>
            </tr>
            <tr>
                <th style="width:7%">ردیف</th>
                <th style="width:10%">کد اموال</th>
                <th style="width:15%">تاریخ تحویل</th>
                <th>مشخصات</th>
            </tr>
            </thead>
            <tbody>
            @php
                $voips=EquipmentedVoip::where('person_id',$personInfo->id)->get();
            @endphp
            @foreach($voips as $key=>$voip)
                <tr>
                    <td style="text-align: center">{{ ++$key }}</td>
                    <td style="text-align: center">{{ $voip->property_number }}</td>
                    <td style="text-align: center">{{ $voip->delivery_date }}</td>
                    <td style="text-align: center">
                        @php
                            $voipInfo = \App\Models\Catalogs\Voip::with('company')->find($voip->copy_machine_id);
                            echo $voipInfo->company->name . ' ' . $voipInfo->model . '<br>';
                        @endphp
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    {{--    switches--}}
    <div style="text-align: center; margin-top: 20px">
        <table class="GeneratedTable">
            <thead>
            <tr style="background-color:#ffcc00">
                <th colspan="5">سوئیچ های ثبت شده</th>
            </tr>
            <tr>
                <th style="width:7%">ردیف</th>
                <th style="width:10%">کد اموال</th>
                <th style="width:15%">تاریخ تحویل</th>
                <th>مشخصات</th>
                <th style="width:10%">تعداد پورت</th>
            </tr>
            </thead>
            <tbody>
            @php
                $switches=EquipmentedSwitch::where('person_id',$personInfo->id)->get();
            @endphp
            @foreach($switches as $key=>$switch)
                <tr>
                    <td style="text-align: center">{{ ++$key }}</td>
                    <td style="text-align: center">{{ $switch->property_number }}</td>
                    <td style="text-align: center">{{ $switch->delivery_date }}</td>
                    <td style="text-align: center">
                        @php
                            $switchInfo = Switches::with('company')->find($switch->switch_id);
                            echo $switchInfo->company->name . ' ' . $switchInfo->model . '<br>';
                        @endphp
                    </td>
                    <td>{{ $switchInfo->ports_number }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    {{--    modems--}}
    <div style="text-align: center; margin-top: 20px">
        <table class="GeneratedTable">
            <thead>
            <tr style="background-color:#ffcc00">
                <th colspan="7">مودم های ثبت شده</th>
            </tr>
            <tr>
                <th style="width:7%">ردیف</th>
                <th style="width:10%">کد اموال</th>
                <th style="width:15%">تاریخ تحویل</th>
                <th>مشخصات</th>
                <th style="width:15%">نوع</th>
                <th style="width:10%">نوع اتصال</th>
                <th style="width:10%">تعداد پورت</th>
            </tr>
            </thead>
            <tbody>
            @php
                $modems=EquipmentedModem::where('person_id',$personInfo->id)->get();
            @endphp
            @foreach($modems as $key=>$modem)
                <tr>
                    <td style="text-align: center">{{ ++$key }}</td>
                    <td style="text-align: center">{{ $modem->property_number }}</td>
                    <td style="text-align: center">{{ $modem->delivery_date }}</td>
                    <td style="text-align: center">
                        @php
                            $modemInfo = Modem::with('company')->find($modem->modem_id);
                            echo $modemInfo->company->name . ' ' . $modemInfo->model . '<br>';
                        @endphp
                    </td>
                    <td>{{ $modemInfo->type }}</td>
                    <td>
                        @php
                            $connectivity_types=json_decode($modemInfo->connectivity_type);
                        @endphp
                        @foreach ($connectivity_types as $types)
                            {{ $types }}
                        @endforeach
                    </td>
                    <td style="text-align: center">{{ $modemInfo->ports_number }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    {{--    mobiles--}}
    <div style="text-align: center; margin-top: 20px">
        <table class="GeneratedTable">
            <thead>
            <tr style="background-color:#ffcc00">
                <th colspan="7">تلفن همراه های ثبت شده</th>
            </tr>
            <tr>
                <th style="width:7%">ردیف</th>
                <th style="width:10%">کد اموال</th>
                <th style="width:15%">تاریخ تحویل</th>
                <th>مشخصات</th>
                <th style="width:10%">رم</th>
                <th style="width:10%">حافظه</th>
                <th style="width:10%">تعداد سیمکارت</th>
            </tr>
            </thead>
            <tbody>
            @php
                $mobiles=EquipmentedMobile::where('person_id',$personInfo->id)->get();
            @endphp
            @foreach($mobiles as $key=>$mobile)
                <tr>
                    <td style="text-align: center">{{ ++$key }}</td>
                    <td style="text-align: center">{{ $mobile->property_number }}</td>
                    <td style="text-align: center">{{ $mobile->delivery_date }}</td>
                    <td style="text-align: center">
                        @php
                            $mobileInfo = Mobile::with('company')->find($mobile->mobile_id);
                            echo $mobileInfo->company->name . ' ' . $mobileInfo->model . '<br>';
                        @endphp
                    </td>
                    <td style="text-align: center">{{ $mobileInfo->ram }}</td>
                    <td style="text-align: center">{{ $mobileInfo->internal_memory }}</td>
                    <td style="text-align: center">{{ $mobileInfo->simcards_number }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    {{--    tablets--}}
    <div style="text-align: center; margin-top: 20px">
        <table class="GeneratedTable">
            <thead>
            <tr style="background-color:#ffcc00">
                <th colspan="7">تبلت های ثبت شده</th>
            </tr>
            <tr>
                <th style="width:7%">ردیف</th>
                <th style="width:10%">کد اموال</th>
                <th style="width:15%">تاریخ تحویل</th>
                <th>مشخصات</th>
                <th style="width:10%">رم</th>
                <th style="width:10%">حافظه</th>
                <th style="width:10%">تعداد سیمکارت</th>
            </tr>
            </thead>
            <tbody>
            @php
                $tablets=EquipmentedTablet::where('person_id',$personInfo->id)->get();
            @endphp
            @foreach($tablets as $key=>$tablet)
                <tr>
                    <td style="text-align: center">{{ ++$key }}</td>
                    <td style="text-align: center">{{ $tablet->property_number }}</td>
                    <td style="text-align: center">{{ $tablet->delivery_date }}</td>
                    <td style="text-align: center">
                        @php
                            $tabletInfo = Tablet::with('company')->find($tablet->tablet_id);
                            echo $tabletInfo->company->name . ' ' . $tabletInfo->model . '<br>';
                        @endphp
                    </td>
                    <td style="text-align: center">{{ $tabletInfo->ram }}</td>
                    <td style="text-align: center">{{ $tabletInfo->internal_memory }}</td>
                    <td style="text-align: center">{{ $tabletInfo->simcards_number }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    {{--    headphones--}}
    <div style="text-align: center; margin-top: 20px">
        <table class="GeneratedTable">
            <thead>
            <tr style="background-color:#ffcc00">
                <th colspan="4">هدفون های ثبت شده</th>
            </tr>
            <tr>
                <th style="width:7%">ردیف</th>
                <th style="width:10%">کد اموال</th>
                <th style="width:15%">تاریخ تحویل</th>
                <th>مشخصات</th>
            </tr>
            </thead>
            <tbody>
            @php
                $headphones=EquipmentedHeadphone::where('person_id',$personInfo->id)->get();
            @endphp
            @foreach($headphones as $key=>$headphone)
                <tr>
                    <td style="text-align: center">{{ ++$key }}</td>
                    <td style="text-align: center">{{ $headphone->property_number }}</td>
                    <td style="text-align: center">{{ $headphone->delivery_date }}</td>
                    <td style="text-align: center">
                        @php
                            $headphoneInfo = Headphone::with('company')->find($headphone->headphone_id);
                            echo $headphoneInfo->company->name . ' ' . $headphoneInfo->model . '<br>';
                        @endphp
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    {{--    recorders--}}
    <div style="text-align: center; margin-top: 20px">
        <table class="GeneratedTable">
            <thead>
            <tr style="background-color:#ffcc00">
                <th colspan="4">رکوردرهای ثبت شده</th>
            </tr>
            <tr>
                <th style="width:7%">ردیف</th>
                <th style="width:10%">کد اموال</th>
                <th style="width:15%">تاریخ تحویل</th>
                <th>مشخصات</th>
            </tr>
            </thead>
            <tbody>
            @php
                $recorders=EquipmentedRecorder::where('person_id',$personInfo->id)->get();
            @endphp
            @foreach($recorders as $key=>$recorder)
                <tr>
                    <td style="text-align: center">{{ ++$key }}</td>
                    <td style="text-align: center">{{ $recorder->property_number }}</td>
                    <td style="text-align: center">{{ $recorder->delivery_date }}</td>
                    <td style="text-align: center">
                        @php
                            $recorderInfo = Recorder::with('company')->find($recorder->recorder_id);
                            echo $recorderInfo->company->name . ' ' . $recorderInfo->model . '<br>';
                        @endphp
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    {{--    webcams--}}
    <div style="text-align: center; margin-top: 20px">
        <table class="GeneratedTable">
            <thead>
            <tr style="background-color:#ffcc00">
                <th colspan="4">وبکم های ثبت شده</th>
            </tr>
            <tr>
                <th style="width:7%">ردیف</th>
                <th style="width:10%">کد اموال</th>
                <th style="width:15%">تاریخ تحویل</th>
                <th>مشخصات</th>
            </tr>
            </thead>
            <tbody>
            @php
                $webcams=EquipmentedWebcam::where('person_id',$personInfo->id)->get();
            @endphp
            @foreach($webcams as $key=>$webcam)
                <tr>
                    <td style="text-align: center">{{ ++$key }}</td>
                    <td style="text-align: center">{{ $webcam->property_number }}</td>
                    <td style="text-align: center">{{ $webcam->delivery_date }}</td>
                    <td style="text-align: center">
                        @php
                            $webcamInfo = Webcam::with('company')->find($webcam->webcam_id);
                            echo $webcamInfo->company->name . ' ' . $webcamInfo->model . '<br>';
                        @endphp
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    {{--    speakers--}}
    <div style="text-align: center; margin-top: 20px">
        <table class="GeneratedTable">
            <thead>
            <tr style="background-color:#ffcc00">
                <th colspan="4">اسپیکرهای ثبت شده</th>
            </tr>
            <tr>
                <th style="width:7%">ردیف</th>
                <th style="width:10%">کد اموال</th>
                <th style="width:15%">تاریخ تحویل</th>
                <th>مشخصات</th>
            </tr>
            </thead>
            <tbody>
            @php
                $speakers=EquipmentedSpeaker::where('person_id',$personInfo->id)->get();
            @endphp
            @foreach($speakers as $key=>$speaker)
                <tr>
                    <td style="text-align: center">{{ ++$key }}</td>
                    <td style="text-align: center">{{ $speaker->property_number }}</td>
                    <td style="text-align: center">{{ $speaker->delivery_date }}</td>
                    <td style="text-align: center">
                        @php
                            $speakerInfo = Speaker::with('company')->find($speaker->speaker_id);
                            echo $speakerInfo->company->name . ' ' . $speakerInfo->model . '<br>';
                        @endphp
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    {{--    video projector--}}
    <div style="text-align: center; margin-top: 20px">
        <table class="GeneratedTable">
            <thead>
            <tr style="background-color:#ffcc00">
                <th colspan="4">ویدئو پروژکتورهای ثبت شده</th>
            </tr>
            <tr>
                <th style="width:7%">ردیف</th>
                <th style="width:10%">کد اموال</th>
                <th style="width:15%">تاریخ تحویل</th>
                <th>مشخصات</th>
            </tr>
            </thead>
            <tbody>
            @php
                $videoprojectors=EquipmentedVideoProjector::where('person_id',$personInfo->id)->get();
            @endphp
            @foreach($videoprojectors as $key=>$videoprojector)
                <tr>
                    <td style="text-align: center">{{ ++$key }}</td>
                    <td style="text-align: center">{{ $videoprojector->property_number }}</td>
                    <td style="text-align: center">{{ $videoprojector->delivery_date }}</td>
                    <td style="text-align: center">
                        @php
                            $videoprojectorInfo = VideoProjector::with('company')->find($videoprojector->video_projector_id);
                            echo $videoprojectorInfo->company->name . ' ' . $videoprojectorInfo->model . '<br>';
                        @endphp
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>


</div>
<htmlpagefooter name="page-footer">
    <p style="text-align:center">
        {PAGENO} از {nbpg}
    </p>
</htmlpagefooter>
</body>
</html>
