@extends('layouts.PanelMaster')

@section('content')
    @php
    $personInfo=\App\Models\Person::find($personId);
    @endphp
    <main class="flex-1 bg-gray-100 py-6 px-8 ">
        <div class=" mx-auto lg:mr-72">
            <h1 class="text-2xl font-bold mb-4">مدیریت اطلاعات تجهیزات کاربر با مشخصات {{ $personInfo->name .' '. $personInfo->family}}</h1>

{{--            Cases--}}
            <h3 class="font-bold pr-5 pt-5">اطلاعات کیس</h3>
            <div class="bg-white rounded shadow p-2 flex flex-col">
                <div class="max-w-full items-center overflow-x-auto">
                    @php
                    $eq_cases=\App\Models\EquipmentedCase::where('person_id',$personId)->get();
                    @endphp
                    @if(!$eq_cases->isEmpty())
                    <table class="w-full border-collapse rounded-lg overflow-hidden text-center">
                        <thead>
                        <tr class="bg-gradient-to-r from-blue-400 to-purple-500 items-center text-center text-white">
                            <th class=" px-6 py-3  font-bold ">کد اموال</th>
                            <th class=" px-6 py-3  font-bold ">کد پلمپ</th>
                            <th class=" px-3 py-3  font-bold ">نام کامپیوتر</th>
                            <th class=" px-3 py-3  font-bold ">کیس</th>
                            <th class=" px-3 py-3  font-bold ">پاور</th>
                            <th class=" px-3 py-3  font-bold ">مادربورد</th>
                            <th class=" px-3 py-3  font-bold ">پردازنده</th>
                            <th class=" px-3 py-3  font-bold ">رم</th>
                            <th class=" px-3 py-3  font-bold ">کارت گرافیک</th>
                            <th class=" px-3 py-3  font-bold ">هارد</th>
                            <th class=" px-3 py-3  font-bold ">درایو نوری</th>
                            <th class=" px-3 py-3  font-bold ">کارت شبکه</th>
                            <th class=" px-3 py-3  font-bold ">عملیات</th>
                        </tr>
                        </thead>
                    </table>
                    @else
                        <h3 class="font-bold pr-5 p-3 text-red-500">این کاربر کیس ثبت شده ندارد</h3>
                    @endif
                </div>
            </div>

            {{--            Cases--}}
            <h3 class="font-bold pr-5 pt-5">اطلاعات مانیتور</h3>
            <div class="bg-white rounded shadow p-2 flex flex-col">
                <div class="max-w-full items-center overflow-x-auto">
                    @php
                        $eq_cases=\App\Models\EquipmentedCase::where('person_id',$personId)->get();
                    @endphp
                    @if(!$eq_cases->isEmpty())
                        <table class="w-full border-collapse rounded-lg overflow-hidden text-center">
                            <thead>
                            <tr class="bg-gradient-to-r from-blue-400 to-purple-500 items-center text-center text-white">
                                <th class=" px-6 py-3  font-bold ">کد اموال</th>
                                <th class=" px-6 py-3  font-bold ">کد پلمپ</th>
                                <th class=" px-3 py-3  font-bold ">نام کامپیوتر</th>
                                <th class=" px-3 py-3  font-bold ">کیس</th>
                                <th class=" px-3 py-3  font-bold ">پاور</th>
                                <th class=" px-3 py-3  font-bold ">مادربورد</th>
                                <th class=" px-3 py-3  font-bold ">پردازنده</th>
                                <th class=" px-3 py-3  font-bold ">رم</th>
                                <th class=" px-3 py-3  font-bold ">کارت گرافیک</th>
                                <th class=" px-3 py-3  font-bold ">هارد</th>
                                <th class=" px-3 py-3  font-bold ">درایو نوری</th>
                                <th class=" px-3 py-3  font-bold ">کارت شبکه</th>
                                <th class=" px-3 py-3  font-bold ">عملیات</th>
                            </tr>
                            </thead>
                        </table>
                    @else
                        <h3 class="font-bold pr-5 p-3 text-red-500">این کاربر کیس ثبت شده ندارد</h3>
                    @endif
                </div>
            </div>

            {{--            Cases--}}
            <h3 class="font-bold pr-5 pt-5">اطلاعات پرینتر</h3>
            <div class="bg-white rounded shadow p-2 flex flex-col">
                <div class="max-w-full items-center overflow-x-auto">
                    @php
                        $eq_cases=\App\Models\EquipmentedCase::where('person_id',$personId)->get();
                    @endphp
                    @if(!$eq_cases->isEmpty())
                        <table class="w-full border-collapse rounded-lg overflow-hidden text-center">
                            <thead>
                            <tr class="bg-gradient-to-r from-blue-400 to-purple-500 items-center text-center text-white">
                                <th class=" px-6 py-3  font-bold ">کد اموال</th>
                                <th class=" px-6 py-3  font-bold ">کد پلمپ</th>
                                <th class=" px-3 py-3  font-bold ">نام کامپیوتر</th>
                                <th class=" px-3 py-3  font-bold ">کیس</th>
                                <th class=" px-3 py-3  font-bold ">پاور</th>
                                <th class=" px-3 py-3  font-bold ">مادربورد</th>
                                <th class=" px-3 py-3  font-bold ">پردازنده</th>
                                <th class=" px-3 py-3  font-bold ">رم</th>
                                <th class=" px-3 py-3  font-bold ">کارت گرافیک</th>
                                <th class=" px-3 py-3  font-bold ">هارد</th>
                                <th class=" px-3 py-3  font-bold ">درایو نوری</th>
                                <th class=" px-3 py-3  font-bold ">کارت شبکه</th>
                                <th class=" px-3 py-3  font-bold ">عملیات</th>
                            </tr>
                            </thead>
                        </table>
                    @else
                        <h3 class="font-bold pr-5 p-3 text-red-500">این کاربر کیس ثبت شده ندارد</h3>
                    @endif
                </div>
            </div>

            {{--            Cases--}}
            <h3 class="font-bold pr-5 pt-5">اطلاعات اسکنر</h3>
            <div class="bg-white rounded shadow p-2 flex flex-col">
                <div class="max-w-full items-center overflow-x-auto">
                    @php
                        $eq_cases=\App\Models\EquipmentedCase::where('person_id',$personId)->get();
                    @endphp
                    @if(!$eq_cases->isEmpty())
                        <table class="w-full border-collapse rounded-lg overflow-hidden text-center">
                            <thead>
                            <tr class="bg-gradient-to-r from-blue-400 to-purple-500 items-center text-center text-white">
                                <th class=" px-6 py-3  font-bold ">کد اموال</th>
                                <th class=" px-6 py-3  font-bold ">کد پلمپ</th>
                                <th class=" px-3 py-3  font-bold ">نام کامپیوتر</th>
                                <th class=" px-3 py-3  font-bold ">کیس</th>
                                <th class=" px-3 py-3  font-bold ">پاور</th>
                                <th class=" px-3 py-3  font-bold ">مادربورد</th>
                                <th class=" px-3 py-3  font-bold ">پردازنده</th>
                                <th class=" px-3 py-3  font-bold ">رم</th>
                                <th class=" px-3 py-3  font-bold ">کارت گرافیک</th>
                                <th class=" px-3 py-3  font-bold ">هارد</th>
                                <th class=" px-3 py-3  font-bold ">درایو نوری</th>
                                <th class=" px-3 py-3  font-bold ">کارت شبکه</th>
                                <th class=" px-3 py-3  font-bold ">عملیات</th>
                            </tr>
                            </thead>
                        </table>
                    @else
                        <h3 class="font-bold pr-5 p-3 text-red-500">این کاربر کیس ثبت شده ندارد</h3>
                    @endif
                </div>
            </div>

            {{--            Copy Machines--}}
            <h3 class="font-bold pr-5 pt-5">اطلاعات دستگاه کپی</h3>
            <div class="bg-white rounded shadow p-2 flex flex-col">
                <div class="max-w-full items-center overflow-x-auto">
                    @php
                        $eq_cases=\App\Models\EquipmentedCase::where('person_id',$personId)->get();
                    @endphp
                    @if(!$eq_cases->isEmpty())
                        <table class="w-full border-collapse rounded-lg overflow-hidden text-center">
                            <thead>
                            <tr class="bg-gradient-to-r from-blue-400 to-purple-500 items-center text-center text-white">
                                <th class=" px-6 py-3  font-bold ">کد اموال</th>
                                <th class=" px-6 py-3  font-bold ">کد پلمپ</th>
                                <th class=" px-3 py-3  font-bold ">نام کامپیوتر</th>
                                <th class=" px-3 py-3  font-bold ">کیس</th>
                                <th class=" px-3 py-3  font-bold ">پاور</th>
                                <th class=" px-3 py-3  font-bold ">مادربورد</th>
                                <th class=" px-3 py-3  font-bold ">پردازنده</th>
                                <th class=" px-3 py-3  font-bold ">رم</th>
                                <th class=" px-3 py-3  font-bold ">کارت گرافیک</th>
                                <th class=" px-3 py-3  font-bold ">هارد</th>
                                <th class=" px-3 py-3  font-bold ">درایو نوری</th>
                                <th class=" px-3 py-3  font-bold ">کارت شبکه</th>
                                <th class=" px-3 py-3  font-bold ">عملیات</th>
                            </tr>
                            </thead>
                        </table>
                    @else
                        <h3 class="font-bold pr-5 p-3 text-red-500">این کاربر کیس ثبت شده ندارد</h3>
                    @endif
                </div>
            </div>

            {{--            VOIPs--}}
            <h3 class="font-bold pr-5 pt-5">اطلاعات VOIP</h3>
            <div class="bg-white rounded shadow p-2 flex flex-col">
                <div class="max-w-full items-center overflow-x-auto">
                    @php
                        $eq_cases=\App\Models\EquipmentedCase::where('person_id',$personId)->get();
                    @endphp
                    @if(!$eq_cases->isEmpty())
                        <table class="w-full border-collapse rounded-lg overflow-hidden text-center">
                            <thead>
                            <tr class="bg-gradient-to-r from-blue-400 to-purple-500 items-center text-center text-white">
                                <th class=" px-6 py-3  font-bold ">کد اموال</th>
                                <th class=" px-6 py-3  font-bold ">کد پلمپ</th>
                                <th class=" px-3 py-3  font-bold ">نام کامپیوتر</th>
                                <th class=" px-3 py-3  font-bold ">کیس</th>
                                <th class=" px-3 py-3  font-bold ">پاور</th>
                                <th class=" px-3 py-3  font-bold ">مادربورد</th>
                                <th class=" px-3 py-3  font-bold ">پردازنده</th>
                                <th class=" px-3 py-3  font-bold ">رم</th>
                                <th class=" px-3 py-3  font-bold ">کارت گرافیک</th>
                                <th class=" px-3 py-3  font-bold ">هارد</th>
                                <th class=" px-3 py-3  font-bold ">درایو نوری</th>
                                <th class=" px-3 py-3  font-bold ">کارت شبکه</th>
                                <th class=" px-3 py-3  font-bold ">عملیات</th>
                            </tr>
                            </thead>
                        </table>
                    @else
                        <h3 class="font-bold pr-5 p-3 text-red-500">این کاربر کیس ثبت شده ندارد</h3>
                    @endif
                </div>
            </div>


        </div>
    </main>
@endsection
