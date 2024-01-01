@extends('layouts.PanelMaster')
@php use App\Models\Device;use App\Models\EquipmentedCase;use App\Models\Person;use App\Models\User;use Morilog\Jalali\Jalalian; @endphp

@section('content')
    <main class="flex-1 bg-cu-light py-6 px-8">
        <div class="mx-auto lg:mr-72 mb-4">
            <form id="showHistory" action="/History/getPersonalCodeHistory" method="get">
                @csrf
                <div class="flex bg-white rounded shadow px-6 py-4">
                    <p class="pt-2 ml-3 font-bold">
                        برای نمایش تاریخچه تغییرات، کد پرسنلی را وارد نمایید:
                    </p>
                    <input type="text" id="personal_code" name="personal_code"
                           @if(isset($_GET['personal_code'])) value="{{ $_GET['personal_code'] }}" @endif
                           class="border rounded-md w-32 px-3 py-2 text-right"
                           placeholder="کد پرسنلی">
                    <button type="submit"
                            class="px-4 py-2 mr-3 h-11 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                        جستجو
                    </button>
                </div>
            </form>
        </div>
        @if(isset($_GET['personal_code']))
            <div class="mx-auto lg:mr-72">
                <h1 class="text-2xl font-bold mb-4">تاریخچه تغییرات بر اساس کد پرسنلی</h1>
                <div class="bg-white rounded shadow p-6">
                    <p>
                    @if( isset($message) )
                        {{ $message }}
                    @else
                        <table class="w-full border-collapse rounded-lg overflow-hidden text-center datasheet">
                            <thead>
                            <tr class="bg-gradient-to-r from-blue-400 to-purple-500 items-center text-center text-white">
                                <th class="px-6 py-2  font-bold ">ردیف</th>
                                <th class="px-6 py-2  font-bold ">کد اموال</th>
                                <th class="px-6 py-2  font-bold ">نوع دستگاه</th>
                                <th class="px-6 py-2  font-bold ">عنوان</th>
                                <th class="px-6 py-2  font-bold ">تاریخ</th>
                                <th class="px-6 py-2  font-bold ">اپراتور</th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-300">
                            @foreach($equipment_log as $logs)
                                @php
                                    if (str_contains($logs->title,'Added') || str_contains($logs->title,'Moved') ){
                                        continue;
                                    }
                                @endphp
                                <tr class="bg-white">
                                    <td class="px-6 py-1">{{ $loop->iteration }}</td>
                                    <td class="px-6 py-1">{{ $logs->property_number }}</td>
                                    <td class="px-6 py-1">{{ $logs->equipment_type }}</td>
                                    <td class="px-6 py-1">
                                        @php
                                            if (str_contains($logs->title,'Assigned')){
                                                $personID=str_replace('Assigned to this user => ','',$logs->title);
                                                $personInfo=Person::find($logs->personal_code);
                                                echo 'اختصاص دستگاه به ' . $personInfo->name . ' ' . $personInfo->family . ' با کد پرسنلی ' . $personID;
                                            }elseif (str_contains($logs->title, 'Device removed from personnel property')) {
                                                $message=json_decode($logs->title,true);
                                                $personnel=Person::where('personnel_code',$message['Personnel'])->first();
                                                echo __('messages.device_removed', ['name' => $personnel->name, 'family' => $personnel->family,'personnel_code' => $personnel->personnel_code]);
                                            }
                                        @endphp

                                    </td>
                                    <td class="px-6 py-1">
                                        {{ Jalalian::fromDateTime($logs->created_at)->format('H:m Y/m/d') }}
                                    </td>
                                    <td class="px-6 py-1">
                                        @php
                                            $userInfo=User::find($logs->operator);
                                        @endphp
                                        {{ $userInfo->name . ' ' . $userInfo->family }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @endif
                </div>
            </div>
    </main>
    @endif
@endsection

