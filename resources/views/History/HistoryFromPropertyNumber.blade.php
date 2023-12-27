@extends('layouts.PanelMaster')
@php
    use App\Models\Device;
    use App\Models\EquipmentedCase;
    use App\Models\EquipmentLog;
    use App\Models\Person;
    use App\Models\User;
    use Morilog\Jalali\Jalalian;
@endphp

@section('content')
    <main class="flex-1 bg-cu-light py-6 px-8">
        <div class="mx-auto lg:mr-72 mb-4">
            <form id="showHistory" action="/History/getPropertyNumberHistory" method="post">
                @csrf
                <div class="flex bg-white rounded shadow px-6 py-4">
                    <p class="pt-2 ml-3 font-bold">
                        برای نمایش تاریخچه تغییرات، کد اموال را وارد نمایید:
                    </p>
                    <input type="text" id="property_number" name="property_number"
                        @if (isset($_POST['property_number'])) value="{{ $_POST['property_number'] }}" @endif
                        class="border rounded-md w-32 px-3 py-2 text-right" placeholder="کد اموال">
                    <button type="submit"
                        class="px-4 py-2 mr-3 h-11 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                        جستجو
                    </button>
                </div>
            </form>
        </div>
        @if (isset($_POST['property_number']))
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
                                                                echo __('messages.changed_property_number', ['from' => $value['from'], 'to' => $value['to']]);
                                                            }
                                                        } else {
                                                            echo 'null';
                                                        }
                                                    } else {
                                                @endphp
                                                @include ('History.Translate.history')
                                                @php
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
