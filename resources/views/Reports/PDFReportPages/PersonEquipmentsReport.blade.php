@php use App\Models\Catalogs\Cases;use App\Models\Catalogs\Company;use App\Models\Catalogs\cpu;use App\Models\Catalogs\GraphicCard;use App\Models\Catalogs\Harddisk;use App\Models\Catalogs\Motherboard;use App\Models\Catalogs\NetworkCard;use App\Models\Catalogs\Odd;use App\Models\Catalogs\Power;use App\Models\Catalogs\Ram;use App\Models\EquipmentedCase; @endphp
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
    <div style="text-align: center;margin: 0 auto;">
        <table class="GeneratedTable">
            <thead>
            <tr>
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
                function getCompanyInfo($company_id){
                    $company=Company::find($company_id);
                    if ($company){
                        return $company;
                    }
                    return null;
                }
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
        <!-- Codes by Quackit.com -->


    </div>
</div>
<htmlpagefooter name="page-footer">
    <p style="text-align:center">
        {PAGENO} از {nbpg}
    </p>
</htmlpagefooter>
</body>
</html>
