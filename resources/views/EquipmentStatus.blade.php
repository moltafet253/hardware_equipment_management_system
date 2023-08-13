@extends('layouts.PanelMaster')

@section('content')
    @php
        $personInfo=\App\Models\Person::find($personId);
    @endphp

    {{--    Modals--}}
    {{--    Case--}}
    <form id="add-case">
        @csrf
        <div class="mt-4 mb-4 flex items-center">
            <div class="fixed z-10 inset-0 overflow-y-auto hidden" id="addCaseModal">
                <div
                    class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center  sm:block sm:p-0">
                    <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                        <div class="absolute inset-0 bg-gray-500 opacity-75 addcase"></div>
                    </div>
                    <div
                        class="inline-block align-bottom bg-white rounded-lg text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full sm:max-w-[550px]">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                                تخصیص کیس به کاربر
                            </h3>
                            <div class="mt-4">
                                <div class="mb-4">
                                    <label for="assistanceForEdit"
                                           class="block text-gray-700 text-sm font-bold mb-2">معاونت/بخش:</label>
                                    <select id="assistanceForEdit"
                                            class="border rounded-md w-full px-3 py-2"
                                            name="assistanceForEdit"
                                            title="معاونت/بخش را وارد کنید (اختیاری)">
                                        <option value="" disabled selected>انتخاب کنید</option>
                                        @php
                                            $assistances=\App\Models\Catalogs\Assistance::orderBy('name')->get();
                                        @endphp
                                        @foreach($assistances as $assistance)
                                            <option
                                                value="{{ $assistance->id }}">{{$assistance->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <input type="hidden" name="personID" id="personID" value="">
                            <button type="submit"
                                    class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                                اضافه کردن
                            </button>
                            <button id="cancel-add-case" type="button"
                                    class="mt-3 w-full inline-flex justify-center px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring focus:border-blue-300 sm:mt-0 sm:w-auto">
                                انصراف
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    {{--    Monitor--}}
    <form id="add-monitor">
        @csrf
        <div class="mt-4 mb-4 flex items-center">
            <div class="fixed z-10 inset-0 overflow-y-auto hidden" id="addMonitorModal">
                <div
                    class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center  sm:block sm:p-0">
                    <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                        <div class="absolute inset-0 bg-gray-500 opacity-75 addmonitor"></div>
                    </div>
                    <div
                        class="inline-block align-bottom bg-white rounded-lg text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full sm:max-w-[550px]">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                                تخصیص مانیتور به کاربر
                            </h3>
                            <div class="mt-4">
                                <div class="mb-4">
                                    <label for="assistanceForEdit"
                                           class="block text-gray-700 text-sm font-bold mb-2">معاونت/بخش:</label>
                                    <select id="assistanceForEdit"
                                            class="border rounded-md w-full px-3 py-2"
                                            name="assistanceForEdit"
                                            title="معاونت/بخش را وارد کنید (اختیاری)">
                                        <option value="" disabled selected>انتخاب کنید</option>
                                        @php
                                            $assistances=\App\Models\Catalogs\Assistance::orderBy('name')->get();
                                        @endphp
                                        @foreach($assistances as $assistance)
                                            <option
                                                value="{{ $assistance->id }}">{{$assistance->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <input type="hidden" name="personID" id="personID" value="">
                            <button type="submit"
                                    class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                                اضافه کردن
                            </button>
                            <button id="cancel-add-monitor" type="button"
                                    class="mt-3 w-full inline-flex justify-center px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring focus:border-blue-300 sm:mt-0 sm:w-auto">
                                انصراف
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    {{--    Printers--}}
    <form id="add-printer">
        @csrf
        <div class="mt-4 mb-4 flex items-center">
            <div class="fixed z-10 inset-0 overflow-y-auto hidden" id="addPrinterModal">
                <div
                    class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center  sm:block sm:p-0">
                    <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                        <div class="absolute inset-0 bg-gray-500 opacity-75 addprinter"></div>
                    </div>
                    <div
                        class="inline-block align-bottom bg-white rounded-lg text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full sm:max-w-[550px]">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                                تخصیص پرینتر به کاربر
                            </h3>
                            <div class="mt-4">
                                <div class="mb-4">
                                    <label for="assistanceForEdit"
                                           class="block text-gray-700 text-sm font-bold mb-2">معاونت/بخش:</label>
                                    <select id="assistanceForEdit"
                                            class="border rounded-md w-full px-3 py-2"
                                            name="assistanceForEdit"
                                            title="معاونت/بخش را وارد کنید (اختیاری)">
                                        <option value="" disabled selected>انتخاب کنید</option>
                                        @php
                                            $assistances=\App\Models\Catalogs\Assistance::orderBy('name')->get();
                                        @endphp
                                        @foreach($assistances as $assistance)
                                            <option
                                                value="{{ $assistance->id }}">{{$assistance->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <input type="hidden" name="personID" id="personID" value="">
                            <button type="submit"
                                    class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                                اضافه کردن
                            </button>
                            <button id="cancel-add-printer" type="button"
                                    class="mt-3 w-full inline-flex justify-center px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring focus:border-blue-300 sm:mt-0 sm:w-auto">
                                انصراف
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    {{--    Scanners--}}
    <form id="add-scanner">
        @csrf
        <div class="mt-4 mb-4 flex items-center">
            <div class="fixed z-10 inset-0 overflow-y-auto hidden" id="addScannerModal">
                <div
                    class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center  sm:block sm:p-0">
                    <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                        <div class="absolute inset-0 bg-gray-500 opacity-75 addscanner"></div>
                    </div>
                    <div
                        class="inline-block align-bottom bg-white rounded-lg text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full sm:max-w-[550px]">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                                تخصیص اسکنر به کاربر
                            </h3>
                            <div class="mt-4">
                                <div class="mb-4">
                                    <label for="assistanceForEdit"
                                           class="block text-gray-700 text-sm font-bold mb-2">معاونت/بخش:</label>
                                    <select id="assistanceForEdit"
                                            class="border rounded-md w-full px-3 py-2"
                                            name="assistanceForEdit"
                                            title="معاونت/بخش را وارد کنید (اختیاری)">
                                        <option value="" disabled selected>انتخاب کنید</option>
                                        @php
                                            $assistances=\App\Models\Catalogs\Assistance::orderBy('name')->get();
                                        @endphp
                                        @foreach($assistances as $assistance)
                                            <option
                                                value="{{ $assistance->id }}">{{$assistance->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <input type="hidden" name="personID" id="personID" value="">
                            <button type="submit"
                                    class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                                اضافه کردن
                            </button>
                            <button id="cancel-add-scanner" type="button"
                                    class="mt-3 w-full inline-flex justify-center px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring focus:border-blue-300 sm:mt-0 sm:w-auto">
                                انصراف
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    {{--    Copy Machines--}}
    <form id="add-copymachine">
        @csrf
        <div class="mt-4 mb-4 flex items-center">
            <div class="fixed z-10 inset-0 overflow-y-auto hidden" id="addCopyMachineModal">
                <div
                    class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center  sm:block sm:p-0">
                    <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                        <div class="absolute inset-0 bg-gray-500 opacity-75 addcopymachine"></div>
                    </div>
                    <div
                        class="inline-block align-bottom bg-white rounded-lg text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full sm:max-w-[550px]">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                                تخصیص دستگاه کپی به کاربر
                            </h3>
                            <div class="mt-4">
                                <div class="mb-4">
                                    <label for="assistanceForEdit"
                                           class="block text-gray-700 text-sm font-bold mb-2">معاونت/بخش:</label>
                                    <select id="assistanceForEdit"
                                            class="border rounded-md w-full px-3 py-2"
                                            name="assistanceForEdit"
                                            title="معاونت/بخش را وارد کنید (اختیاری)">
                                        <option value="" disabled selected>انتخاب کنید</option>
                                        @php
                                            $assistances=\App\Models\Catalogs\Assistance::orderBy('name')->get();
                                        @endphp
                                        @foreach($assistances as $assistance)
                                            <option
                                                value="{{ $assistance->id }}">{{$assistance->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <input type="hidden" name="personID" id="personID" value="">
                            <button type="submit"
                                    class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                                اضافه کردن
                            </button>
                            <button id="cancel-add-copymachine" type="button"
                                    class="mt-3 w-full inline-flex justify-center px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring focus:border-blue-300 sm:mt-0 sm:w-auto">
                                انصراف
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    {{--    VOIPs--}}
    <form id="add-voip">
        @csrf
        <div class="mt-4 mb-4 flex items-center">
            <div class="fixed z-10 inset-0 overflow-y-auto hidden" id="addVOIPModal">
                <div
                    class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center  sm:block sm:p-0">
                    <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                        <div class="absolute inset-0 bg-gray-500 opacity-75 addVOIP"></div>
                    </div>
                    <div
                        class="inline-block align-bottom bg-white rounded-lg text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full sm:max-w-[550px]">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                                تخصیص VOIP به کاربر
                            </h3>
                            <div class="mt-4">
                                <div class="mb-4">
                                    <label for="assistanceForEdit"
                                           class="block text-gray-700 text-sm font-bold mb-2">معاونت/بخش:</label>
                                    <select id="assistanceForEdit"
                                            class="border rounded-md w-full px-3 py-2"
                                            name="assistanceForEdit"
                                            title="معاونت/بخش را وارد کنید (اختیاری)">
                                        <option value="" disabled selected>انتخاب کنید</option>
                                        @php
                                            $assistances=\App\Models\Catalogs\Assistance::orderBy('name')->get();
                                        @endphp
                                        @foreach($assistances as $assistance)
                                            <option
                                                value="{{ $assistance->id }}">{{$assistance->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <input type="hidden" name="personID" id="personID" value="">
                            <button type="submit"
                                    class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                                اضافه کردن
                            </button>
                            <button id="cancel-add-voip" type="button"
                                    class="mt-3 w-full inline-flex justify-center px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring focus:border-blue-300 sm:mt-0 sm:w-auto">
                                انصراف
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <main class="flex-1 bg-gray-100 py-6 px-8 ">
        <div class=" mx-auto lg:mr-72">
            <h1 class="text-2xl font-bold mb-4">مدیریت اطلاعات تجهیزات کاربر با
                مشخصات {{ $personInfo->name .' '. $personInfo->family}}</h1>

            {{--            Cases--}}
            <h3 class="font-bold pr-5 pt-5">اطلاعات کیس</h3>
            <div class="bg-white rounded shadow flex flex-col">
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
                        <div class="flex p-3">
                            <h3 class="font-bold text-red-500 ml-4 mt-2">این کاربر کیس ثبت شده ندارد</h3>
                            <button type="submit"
                                    class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300 AddCase">
                                ثبت کیس جدید
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            {{--            Monitors--}}
            <h3 class="font-bold pr-5 pt-5">اطلاعات مانیتور</h3>
            <div class="bg-white rounded shadow flex flex-col">
                <div class="max-w-full items-center overflow-x-auto">
                    @php
                        $eq_monitors=\App\Models\EquipmentedMonitor::where('person_id',$personId)->get();
                    @endphp
                    @if(!$eq_monitors->isEmpty())
                        <table class="w-full border-collapse rounded-lg overflow-hidden text-center">
                            <thead>
                            <tr class="bg-gradient-to-r from-blue-400 to-purple-500 items-center text-center text-white">
                                <th class=" px-6 py-3  font-bold ">کد اموال</th>
                                <th class=" px-3 py-3  font-bold ">شرکت سازنده</th>
                                <th class=" px-3 py-3  font-bold ">مدل</th>
                                <th class=" px-3 py-3  font-bold ">سایز</th>
                                <th class=" px-3 py-3  font-bold ">عملیات</th>
                            </tr>
                            </thead>
                        </table>
                    @else
                        <div class="flex p-3">
                            <h3 class="font-bold text-red-500 ml-4 mt-2">این کاربر مانیتور ثبت شده ندارد</h3>
                            <button type="submit"
                                    class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300 AddMonitor">
                                ثبت مانیتور جدید
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            {{--            Printers--}}
            <h3 class="font-bold pr-5 pt-5">اطلاعات پرینتر</h3>
            <div class="bg-white rounded shadow flex flex-col">
                <div class="max-w-full items-center overflow-x-auto">
                    @php
                        $eq_printers=\App\Models\EquipmentedPrinter::where('person_id',$personId)->get();
                    @endphp
                    @if(!$eq_printers->isEmpty())
                        <table class="w-full border-collapse rounded-lg overflow-hidden text-center">
                            <thead>
                            <tr class="bg-gradient-to-r from-blue-400 to-purple-500 items-center text-center text-white">
                                <th class=" px-6 py-3  font-bold ">کد اموال</th>
                                <th class=" px-3 py-3  font-bold ">شرکت سازنده</th>
                                <th class=" px-3 py-3  font-bold ">مدل</th>
                                <th class=" px-3 py-3  font-bold ">عملیات</th>
                            </tr>
                            </thead>
                        </table>
                    @else
                        <div class="flex p-3">
                            <h3 class="font-bold text-red-500 ml-4 mt-2">این کاربر پرینتر ثبت شده ندارد</h3>
                            <button type="submit"
                                    class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300 AddPrinter">
                                ثبت پرینتر جدید
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            {{--            Scanners--}}
            <h3 class="font-bold pr-5 pt-5">اطلاعات اسکنر</h3>
            <div class="bg-white rounded shadow flex flex-col">
                <div class="max-w-full items-center overflow-x-auto">
                    @php
                        $eq_scanners=\App\Models\EquipmentedScanner::where('person_id',$personId)->get();
                    @endphp
                    @if(!$eq_scanners->isEmpty())
                        <table class="w-full border-collapse rounded-lg overflow-hidden text-center">
                            <thead>
                            <tr class="bg-gradient-to-r from-blue-400 to-purple-500 items-center text-center text-white">
                                <th class=" px-6 py-3  font-bold ">کد اموال</th>
                                <th class=" px-3 py-3  font-bold ">شرکت سازنده</th>
                                <th class=" px-3 py-3  font-bold ">مدل</th>
                                <th class=" px-3 py-3  font-bold ">عملیات</th>
                            </tr>
                            </thead>
                        </table>
                    @else
                        <div class="flex p-3">
                            <h3 class="font-bold text-red-500 ml-4 mt-2">این کاربر اسکنر ثبت شده ندارد</h3>
                            <button type="submit"
                                    class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300 AddScanner">
                                ثبت اسکنر جدید
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            {{--            Copy Machines--}}
            <h3 class="font-bold pr-5 pt-5">اطلاعات دستگاه کپی</h3>
            <div class="bg-white rounded shadow flex flex-col">
                <div class="max-w-full items-center overflow-x-auto">
                    @php
                        $eq_copy_machines=\App\Models\EquipmentedCopyMachine::where('person_id',$personId)->get();
                    @endphp
                    @if(!$eq_copy_machines->isEmpty())
                        <table class="w-full border-collapse rounded-lg overflow-hidden text-center">
                            <thead>
                            <tr class="bg-gradient-to-r from-blue-400 to-purple-500 items-center text-center text-white">
                                <th class=" px-6 py-3  font-bold ">کد اموال</th>
                                <th class=" px-3 py-3  font-bold ">شرکت سازنده</th>
                                <th class=" px-3 py-3  font-bold ">مدل</th>
                                <th class=" px-3 py-3  font-bold ">عملیات</th>
                            </tr>
                            </thead>
                        </table>
                    @else
                        <div class="flex p-3">
                            <h3 class="font-bold text-red-500 ml-4 mt-2">این کاربر دستگاه کپی ثبت شده ندارد</h3>
                            <button type="submit"
                                    class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300 AddCopyMachine">
                                ثبت دستگاه کپی جدید
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            {{--            VOIPs--}}
            <h3 class="font-bold pr-5 pt-5">اطلاعات VOIP</h3>
            <div class="bg-white rounded shadow flex flex-col">
                <div class="max-w-full items-center overflow-x-auto">
                    @php
                        $eq_VOIPs=\App\Models\EquipmentedVoip::where('person_id',$personId)->get();
                    @endphp
                    @if(!$eq_VOIPs->isEmpty())
                        <table class="w-full border-collapse rounded-lg overflow-hidden text-center">
                            <thead>
                            <tr class="bg-gradient-to-r from-blue-400 to-purple-500 items-center text-center text-white">
                                <th class=" px-6 py-3  font-bold ">کد اموال</th>
                                <th class=" px-3 py-3  font-bold ">شرکت سازنده</th>
                                <th class=" px-3 py-3  font-bold ">مدل</th>
                                <th class=" px-3 py-3  font-bold ">عملیات</th>
                            </tr>
                            </thead>
                        </table>
                    @else
                        <div class="flex p-3">
                            <h3 class="font-bold text-red-500 ml-4 mt-2">این کاربر VOIP ثبت شده ندارد</h3>
                            <button type="submit"
                                    class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300 AddVOIP">
                                ثبت VOIP جدید
                            </button>
                        </div>
                    @endif
                </div>
            </div>


        </div>
    </main>
@endsection
