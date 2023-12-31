@extends('layouts.PanelMaster')
@php
    use App\Models\Device;
    use App\Models\EquipmentedCase;
    use App\Models\EquipmentLog;
    use App\Models\Person;
    use App\Models\User;
    use Morilog\Jalali\Jalalian;
    use App\Models\Catalogs\Company;
    use App\Models\Catalogs\Cases;
    use App\Models\Catalogs\Monitor;
    use App\Models\Catalogs\Motherboard;
    use App\Models\Catalogs\cpu;
    use App\Models\Catalogs\Ram;
    use App\Models\Catalogs\Harddisk;
    use App\Models\Catalogs\GraphicCard;
    use App\Models\Catalogs\NetworkCard;
    use App\Models\Catalogs\Odd;
    use App\Models\Catalogs\Printer;
    use App\Models\Catalogs\Scanner;
@endphp

@section('content')
    <main class="flex-1 bg-cu-light py-6 px-8">
        <div class="mx-auto lg:mr-72 mb-4">
            <form id="showHistory" action="{{ route('getPropertyNumberHistory') }}" method="get">
                <div class="flex bg-white rounded shadow px-6 py-4">
                    <p class="pt-2 ml-3 font-bold">
                        برای نمایش تاریخچه تغییرات، کد اموال را وارد نمایید:
                    </p>
                    <input type="text" id="property_number" name="property_number"
                        @if (isset($_GET['property_number'])) value="{{ $_GET['property_number'] }}" @endif
                        class="border rounded-md w-32 px-3 py-2 text-right" placeholder="کد اموال">
                    <button type="submit"
                        class="px-4 py-2 mr-3 h-11 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                        جستجو
                    </button>
                </div>
            </form>
        </div>
        @if (isset($_GET['property_number']))
            <div class="mx-auto lg:mr-72">
                <h1 class="text-2xl font-bold mb-4">تاریخچه تغییرات بر اساس کد اموال</h1>
                <div class="bg-white rounded shadow p-6">
                    <p>
                        @if (isset($message))
                            {{ $message }}
                        @else
                            <table class="w-full border-collapse rounded-lg overflow-hidden text-center datasheet">
                                <thead>
                                    <tr
                                        class="bg-gradient-to-r from-blue-400 to-purple-500 items-center text-center text-white">
                                        <th class="px-6 py-2  font-bold ">ردیف</th>
                                        <th class="px-6 py-2  font-bold ">پرسنل</th>
                                        <th class="px-6 py-2  font-bold ">عنوان</th>
                                        <th class="px-6 py-2  font-bold ">تاریخ</th>
                                        <th class="px-6 py-2  font-bold ">اپراتور</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-300">
                                    @foreach ($equipment_log as $logs)
                                        <tr class="bg-white">
                                            <td class="px-6 py-1">{{ $loop->iteration }}</td>
                                            <td class="px-6 py-1">
                                                @php
                                                    $personInfo = Person::find($logs->personal_code);
                                                @endphp
                                                {{ $personInfo->personnel_code . ' - ' . $personInfo->name . ' ' . $personInfo->family }}
                                            </td>
                                            <td class="px-6 py-1">

                                                @php
                                                    if (str_contains($logs->title, 'Added')) {
                                                        echo __('messages.device_added', ['property_number' => $logs->property_number]);
                                                    } elseif (str_contains($logs->title, 'Assigned')) {
                                                        echo __('messages.device_assigned', ['name' => $personInfo->name, 'family' => $personInfo->family, 'personnel_code' => $personInfo->personnel_code]);
                                                    } elseif (str_contains($logs->title, 'Changed property number')) {
                                                        $nextLog = EquipmentLog::find(++$logs->id);
                                                        if ($nextLog) {
                                                            foreach (json_decode($nextLog->title, true) as $value) {
                                                                switch ($value['field']) {
                                                                    case 'case_id':
                                                                    case 'delivery_date':
                                                                        echo 'تغییر تاریخ تحویل از: ' . $value['from'] . ' به: ' . $value['to'] . '<br/>';
                                                                        break;
                                                                    case 'property_number':
                                                                        echo 'تغییر کد اموال از: ' . $value['from'] . ' به: ' . $value['to'] . '<br/>';
                                                                        break;
                                                                    case 'case':
                                                                        $from_company = Cases::with('company')->find($value['from']);
                                                                        $to_company = Cases::with('company')->find($value['to']);
                                                                        echo 'تغییر کیس از: ' . $from_company->company->name . ' ' . $from_company->model . ' به: ' . $to_company->company->name . ' ' . $to_company->model . '<br/>';
                                                                        break;
                                                                    case 'motherboard':
                                                                        $from_company = Motherboard::with('company')->find($value['from']);
                                                                        $to_company = Motherboard::with('company')->find($value['to']);
                                                                        echo 'تغییر مادربورد از: ' . $from_company->company->name . ' ' . $from_company->model . ' به: ' . $to_company->company->name . ' ' . $to_company->model . '<br/>';
                                                                        break;
                                                                    case 'cpu':
                                                                        $from_company = cpu::with('company')->find($value['from']);
                                                                        $to_company = cpu::with('company')->find($value['to']);
                                                                        echo 'تغییر پردازنده از: ' . $from_company->company->name . ' ' . $from_company->model . ' به: ' . $to_company->company->name . ' ' . $to_company->model . '<br/>';
                                                                        break;
                                                                        break;
                                                                    case 'ram1':
                                                                        $from_company = Ram::with('company')->find($value['from']);
                                                                        $to_company = Ram::with('company')->find($value['to']);
                                                                        echo 'تغییر رم 1 از: ' . $from_company->company->name . ' ' . $from_company->model . ' ' . $from_company->type . ' ' . $from_company->size . ' ' . $from_company->frequerncy . ' به: ' . $to_company->company->name . ' ' . $to_company->model . ' ' . $to_company->type . ' ' . $to_company->size . ' ' . $to_company->frequerncy . '<br/>';
                                                                        break;
                                                                    case 'ram2':
                                                                        $from_company = Ram::with('company')->find($value['from']);
                                                                        $to_company = Ram::with('company')->find($value['to']);
                                                                        echo 'تغییر رم 2 از: ' . @$from_company->company->name . ' ' . @$from_company->model . ' ' . @$from_company->type . ' ' . @$from_company->size . ' ' . @$from_company->frequerncy . ' به: ' . @$to_company->company->name . ' ' . @$to_company->model . ' ' . @$to_company->type . ' ' . @$to_company->size . ' ' . @$to_company->frequerncy . '<br/>';
                                                                        break;
                                                                    case 'ram3':
                                                                        $from_company = Ram::with('company')->find($value['from']);
                                                                        $to_company = Ram::with('company')->find($value['to']);
                                                                        echo 'تغییر رم 3 از: ' . @$from_company->company->name . ' ' . @$from_company->model . ' ' . @$from_company->type . ' ' . @$from_company->size . ' ' . @$from_company->frequerncy . ' به: ' . @$to_company->company->name . ' ' . @$to_company->model . ' ' . @$to_company->type . ' ' . @$to_company->size . ' ' . @$to_company->frequerncy . '<br/>';
                                                                        break;
                                                                    case 'ram4':
                                                                        $from_company = Ram::with('company')->find($value['from']);
                                                                        $to_company = Ram::with('company')->find($value['to']);
                                                                        echo 'تغییر رم 4 از: ' . @$from_company->company->name . ' ' . @$from_company->model . ' ' . @$from_company->type . ' ' . @$from_company->size . ' ' . @$from_company->frequerncy . ' به: ' . @$to_company->company->name . ' ' . @$to_company->model . ' ' . @$to_company->type . ' ' . @$to_company->size . ' ' . @$to_company->frequerncy . '<br/>';
                                                                        break;
                                                                    case 'hdd1':
                                                                        $from_company = Harddisk::with('company')->find($value['from']);
                                                                        $to_company = Harddisk::with('company')->find($value['to']);
                                                                        echo 'تغییر هارد 1 از: ' . $from_company->company->name . ' ' . $from_company->model . ' ' . $from_company->capacity . ' ' . $from_company->type . ' ' . $from_company->connectivity_type . ' به: ' . $to_company->company->name . ' ' . $to_company->model . ' ' . $to_company->capacity . ' ' . $to_company->type . ' ' . $to_company->connectivity_type . '<br/>';
                                                                        break;
                                                                    case 'hdd2':
                                                                        $from_company = Harddisk::with('company')->find($value['from']);
                                                                        $to_company = Harddisk::with('company')->find($value['to']);
                                                                        echo 'تغییر هارد 2 از: ' . @$from_company->company->name . ' ' . @$from_company->model . ' ' . @$from_company->capacity . ' ' . @$from_company->type . ' ' . @$from_company->connectivity_type . ' به: ' . @$to_company->company->name . ' ' . @$to_company->model . ' ' . @$to_company->capacity . ' ' . @$to_company->type . ' ' . @$to_company->connectivity_type . '<br/>';
                                                                        break;
                                                                    case 'hdd3':
                                                                        $from_company = Harddisk::with('company')->find($value['from']);
                                                                        $to_company = Harddisk::with('company')->find($value['to']);
                                                                        echo 'تغییر هارد 3 از: ' . @$from_company->company->name . ' ' . @$from_company->model . ' ' . @$from_company->capacity . ' ' . @$from_company->type . ' ' . @$from_company->connectivity_type . ' به: ' . @$to_company->company->name . ' ' . @$to_company->model . ' ' . @$to_company->capacity . ' ' . @$to_company->type . ' ' . @$to_company->connectivity_type . '<br/>';
                                                                        break;
                                                                    case 'hdd4':
                                                                        $from_company = Harddisk::with('company')->find($value['from']);
                                                                        $to_company = Harddisk::with('company')->find($value['to']);
                                                                        echo 'تغییر هارد 4 از: ' . @$from_company->company->name . ' ' . @$from_company->model . ' ' . @$from_company->capacity . ' ' . @$from_company->type . ' ' . @$from_company->connectivity_type . ' به: ' . @$to_company->company->name . ' ' . @$to_company->model . ' ' . @$to_company->capacity . ' ' . @$to_company->type . ' ' . @$to_company->connectivity_type . '<br/>';
                                                                        break;
                                                                    case 'graphic_card':
                                                                        $from_company = GraphicCard::with('company')->find($value['from']);
                                                                        $to_company = GraphicCard::with('company')->find($value['to']);
                                                                        echo 'تغییر کارت گرافیک از: ' . @$from_company->company->name . ' ' . @$from_company->model . ' ' . @$from_company->capacity . ' ' . @$from_company->type . ' ' . @$from_company->connectivity_type . ' به: ' . @$to_company->company->name . ' ' . @$to_company->model . ' ' . @$to_company->capacity . ' ' . @$to_company->type . ' ' . @$to_company->connectivity_type . '<br/>';
                                                                        break;
                                                                    case 'network_card':
                                                                        $from_company = NetworkCard::with('company')->find($value['from']);
                                                                        $to_company = NetworkCard::with('company')->find($value['to']);
                                                                        echo 'تغییر کارت شبکه از: ' . @$from_company->company->name . ' ' . @$from_company->model . ' ' . @$from_company->capacity . ' ' . @$from_company->type . ' ' . @$from_company->connectivity_type . ' به: ' . @$to_company->company->name . ' ' . @$to_company->model . ' ' . @$to_company->capacity . ' ' . @$to_company->type . ' ' . @$to_company->connectivity_type . '<br/>';
                                                                        break;
                                                                    case 'odd':
                                                                        $from_company = Odd::with('company')->find($value['from']);
                                                                        $to_company = Odd::with('company')->find($value['to']);
                                                                        echo 'تغییر کارت شبکه از: ' . @$from_company->company->name . ' ' . @$from_company->model . ' ' . @$from_company->capacity . ' ' . @$from_company->type . ' ' . @$from_company->connectivity_type . ' به: ' . @$to_company->company->name . ' ' . @$to_company->model . ' ' . @$to_company->capacity . ' ' . @$to_company->type . ' ' . @$to_company->connectivity_type . '<br/>';
                                                                        break;
                                                                    case 'monitor_id':
                                                                        $from = Monitor::find($change['from']);
                                                                        $from_company = Company::find($from->company_id);
                                                                        $to = Monitor::find($change['to']);
                                                                        $to_company = Company::find($to->company_id);
                                                                        echo 'تغییر مانیتور از: ' . $from_company->name . ' ' . $from->model . ' به: ' . $to_company->name . ' ' . $to->model;
                                                                        break;
                                                                    case 'printer_id':
                                                                        $from = Printer::find($change['from']);
                                                                        $from_company = Company::find($from->company_id);
                                                                        $to = Printer::find($change['to']);
                                                                        $to_company = Company::find($to->company_id);
                                                                        echo 'تغییر پرینتر از: ' . $from_company->name . ' ' . $from->model . ' ' . $from->function_type . ' به: ' . $to_company->name . ' ' . $to->model . ' ' . $to->function_type;
                                                                        break;
                                                                    case 'scanner_id':
                                                                        $from = Scanner::find($change['from']);
                                                                        $from_company = Company::find($from->company_id);
                                                                        $to = Scanner::find($change['to']);
                                                                        $to_company = Company::find($to->company_id);
                                                                        echo 'تغییر اسکنر از: ' . $from_company->name . ' ' . $from->model . ' ' . $from->function_type . ' به: ' . $to_company->name . ' ' . $to->model . ' ' . $to->function_type;
                                                                        break;
                                                                    default:
                                                                    // اگر نیاز به انجام عملیاتی برای حالت‌های دیگر هست، می‌توانید اینجا اضافه کنید.
                                                                }
                                                            }
                                                        } else {
                                                            echo 'null';
                                                        }
                                                    }
                                                @endphp
                                            </td>
                                            <td class="px-6 py-1">
                                                {{ Jalalian::fromDateTime($logs->created_at)->format('H:m Y/m/d') }}
                                            </td>
                                            <td class="px-6 py-1">
                                                @php
                                                    $userInfo = User::find($logs->operator);
                                                @endphp
                                                {{ $userInfo->name . ' ' . $userInfo->family }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </p>
                </div>
            </div>
    </main>
    @endif
@endsection
