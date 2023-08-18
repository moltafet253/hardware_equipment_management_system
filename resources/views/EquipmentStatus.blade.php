@extends('layouts.PanelMaster')

@section('content')
    @php
        $personInfo=\App\Models\Person::find($personId);
    @endphp

    {{--    Modals--}}
    {{--    Case--}}
    <form id="new-case">
        @csrf
        <div class="mt-4 mb-4 flex items-center">
            {{--            <div class="fixed z-10 inset-0 overflow-y-auto " id="addCaseModal">--}}
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
                                <div class="flex">
                                    <div class="ml-3 w-full">
                                        <label for="property_number"
                                               class="block text-gray-700 text-sm font-bold mb-2">کد اموال*</label>
                                        <input type="text" id="property_number" name="property_number"
                                               class="border rounded-md w-full mb-4 px-3 py-2 text-right "
                                               placeholder="کد اموال را وارد کنید">
                                    </div>
                                    <div class="w-full">
                                        <label for="stamp_number"
                                               class="block text-gray-700 text-sm font-bold mb-2">کد پلمپ*</label>
                                        <input type="text" id="stamp_number" name="stamp_number"
                                               class="border rounded-md w-full mb-4 px-3 py-2 text-right"
                                               placeholder="کد پلمپ را وارد کنید">
                                    </div>
                                </div>
                                <div class="flex">
                                    <div class="ml-3 w-full">
                                        <label for="computer_name"
                                               class="block text-gray-700 text-sm font-bold mb-2">نام کامپیوتر</label>
                                        <input type="text" id="computer_name" name="computer_name"
                                               class="border rounded-md w-full mb-4 px-3 py-2 text-right"
                                               placeholder="نام کامپیوتر را وارد کنید">
                                    </div>
                                    <div class="w-full">
                                        <label for="delivery_date"
                                               class="block text-gray-700 text-sm font-bold mb-2">تاریخ تحویل</label>
                                        <input type="text" id="delivery_date" name="delivery_date"
                                               class="border rounded-md w-full mb-4 px-3 py-2 text-right"
                                               placeholder="با فرمت : 1402/05/04">
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="case"
                                           class="block text-gray-700 text-sm font-bold mb-2">کیس*</label>
                                    <select id="case" class="border rounded-md w-full px-3 py-2" name="case">
                                        <option value="" disabled selected>انتخاب کنید</option>
                                        @php
                                            $cases = \App\Models\Catalogs\Cases::join('companies', 'cases.company_id', '=', 'companies.id')
                                                ->orderBy('companies.name')
                                                ->get(['cases.id', 'companies.name', 'cases.model']);
                                        @endphp
                                        @foreach($cases as $case)
                                            <option value="{{ $case->id }}">
                                                {{ $case->name . ' - ' . $case->model }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label for="motherboard"
                                           class="block text-gray-700 text-sm font-bold mb-2">مادربورد*</label>
                                    <select id="motherboard" class="border rounded-md w-full px-3 py-2"
                                            name="motherboard">
                                        <option value="" disabled selected>انتخاب کنید</option>
                                        @php
                                            $motherboards = \App\Models\Catalogs\Motherboard::join('companies', 'motherboards.company_id', '=', 'companies.id')
                                                ->orderBy('companies.name')
                                                ->get(['motherboards.id', 'companies.name', 'motherboards.model']);
                                        @endphp
                                        @foreach($motherboards as $motherboard)
                                            <option value="{{ $motherboard->id }}">
                                                {{ $motherboard->name . ' - ' . $motherboard->model }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label for="power"
                                           class="block text-gray-700 text-sm font-bold mb-2">منبع تغذیه*</label>
                                    <select id="power" class="border rounded-md w-full px-3 py-2" name="power">
                                        <option value="" disabled selected>انتخاب کنید</option>
                                        @php
                                            $powers = \App\Models\Catalogs\Power::join('companies', 'powers.company_id', '=', 'companies.id')
                                                ->orderBy('companies.name')
                                                ->get(['powers.id', 'companies.name', 'powers.model']);
                                        @endphp
                                        @foreach($powers as $power)
                                            <option value="{{ $power->id }}">
                                                {{ $power->name . ' - ' . $power->model }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label for="cpu"
                                           class="block text-gray-700 text-sm font-bold mb-2">پردازنده*</label>
                                    <select id="cpu" class="border rounded-md w-full px-3 py-2" name="cpu">
                                        <option value="" disabled selected>انتخاب کنید</option>
                                        @php
                                            $cpus = \App\Models\Catalogs\cpu::join('companies', 'cpus.company_id', '=', 'companies.id')
                                                ->orderBy('companies.name')
                                                ->get(['cpus.id', 'companies.name', 'cpus.model']);
                                        @endphp
                                        @foreach($cpus as $cpu)
                                            <option value="{{ $cpu->id }}">
                                                {{ $cpu->name . ' - ' . $cpu->model }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="flex ">
                                    <div class="ml-3 w-2/4">
                                        <label for="ram1"
                                               class="block text-gray-700 text-sm font-bold mt-3 whitespace-nowrap">رم
                                            1*</label>
                                        <select id="ram1" class="border rounded-md w-full px-3 py-2" name="ram1">
                                            <option value="" disabled selected>انتخاب کنید</option>
                                            @php
                                                $rams = \App\Models\Catalogs\Ram::join('companies', 'rams.company_id', '=', 'companies.id')
                                                    ->orderBy('companies.name')
                                                    ->get(['rams.id', 'companies.name', 'rams.model', 'rams.type', 'rams.size']);
                                            @endphp
                                            @foreach($rams as $ram)
                                                <option value="{{ $ram->id }}">
                                                    {{ $ram->name . ' - ' . $ram->model . ' - ' . $ram->type. ' - ' . $ram->size}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="w-2/4">
                                        <label for="ram2"
                                               class="block text-gray-700 text-sm font-bold mt-3 whitespace-nowrap">رم
                                            2</label>
                                        <select id="ram2" class="border rounded-md w-full px-3 py-2" name="ram2">
                                            <option value="" selected>فاقد رم</option>
                                            @php
                                                $rams = \App\Models\Catalogs\Ram::join('companies', 'rams.company_id', '=', 'companies.id')
                                                    ->orderBy('companies.name')
                                                    ->get(['rams.id', 'companies.name', 'rams.model', 'rams.type', 'rams.size']);
                                            @endphp
                                            @foreach($rams as $ram)
                                                <option value="{{ $ram->id }}">
                                                    {{ $ram->name . ' - ' . $ram->model . ' - ' . $ram->type. ' - ' . $ram->size}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="flex mb-4">
                                    <div class="ml-3 w-2/4">
                                        <label for="ram3"
                                               class="block text-gray-700 text-sm font-bold mt-3 whitespace-nowrap">رم
                                            3</label>
                                        <select id="ram3" class="border rounded-md w-full px-3 py-2" name="ram3">
                                            <option value="" selected>فاقد رم</option>
                                            @php
                                                $rams = \App\Models\Catalogs\Ram::join('companies', 'rams.company_id', '=', 'companies.id')
                                                    ->orderBy('companies.name')
                                                    ->get(['rams.id', 'companies.name', 'rams.model', 'rams.type', 'rams.size']);
                                            @endphp
                                            @foreach($rams as $ram)
                                                <option value="{{ $ram->id }}">
                                                    {{ $ram->name . ' - ' . $ram->model . ' - ' . $ram->type. ' - ' . $ram->size}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="w-2/4">
                                        <label for="ram4"
                                               class="block text-gray-700 text-sm font-bold mt-3 whitespace-nowrap">رم
                                            4</label>
                                        <select id="ram4" class="border rounded-md w-full px-3 py-2" name="ram4">
                                            <option value="" selected>فاقد رم</option>
                                            @php
                                                $rams = \App\Models\Catalogs\Ram::join('companies', 'rams.company_id', '=', 'companies.id')
                                                    ->orderBy('companies.name')
                                                    ->get(['rams.id', 'companies.name', 'rams.model', 'rams.type', 'rams.size']);
                                            @endphp
                                            @foreach($rams as $ram)
                                                <option value="{{ $ram->id }}">
                                                    {{ $ram->name . ' - ' . $ram->model . ' - ' . $ram->type. ' - ' . $ram->size}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="flex mb-4">
                                    <div class="ml-3 w-2/4">
                                        <label for="hdd1"
                                               class="block text-gray-700 text-sm font-bold mt-3 whitespace-nowrap">هارد
                                            1*</label>
                                        <select id="hdd1" class="border rounded-md w-full px-3 py-2" name="hdd1">
                                            <option value="" disabled selected>انتخاب کنید</option>
                                            @php
                                                $hdds = \App\Models\Catalogs\Harddisk::join('companies', 'harddisks.company_id', '=', 'companies.id')
                                                    ->where('harddisks.type','!=','External')
                                                    ->orderBy('companies.name')
                                                    ->get(['harddisks.id', 'companies.name', 'harddisks.model', 'harddisks.capacity','harddisks.connectivity_type',]);
                                            @endphp
                                            @foreach($hdds as $hdd)
                                                <option value="{{ $hdd->id }}">
                                                    {{ $hdd->name . ' - ' . $hdd->model . ' - ' . $hdd->capacity. ' - ' . $hdd->connectivity_type}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="w-2/4">
                                        <label for="hdd2"
                                               class="block text-gray-700 text-sm font-bold mt-3 whitespace-nowrap">هارد
                                            2</label>
                                        <select id="hdd2" class="border rounded-md w-full px-3 py-2" name="hdd2">
                                            <option value="" selected>فاقد رم</option>
                                            @php
                                                $hdds = \App\Models\Catalogs\Harddisk::join('companies', 'harddisks.company_id', '=', 'companies.id')
                                                    ->where('harddisks.type','!=','External')
                                                    ->orderBy('companies.name')
                                                    ->get(['harddisks.id', 'companies.name', 'harddisks.model', 'harddisks.capacity','harddisks.connectivity_type',]);
                                            @endphp
                                            @foreach($hdds as $hdd)
                                                <option value="{{ $hdd->id }}">
                                                    {{ $hdd->name . ' - ' . $hdd->model . ' - ' . $hdd->capacity. ' - ' . $hdd->connectivity_type}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="graphiccard"
                                           class="block text-gray-700 text-sm font-bold mb-2">کارت گرافیک*</label>
                                    <select id="graphiccard" class="border rounded-md w-full px-3 py-2"
                                            name="graphiccard">
                                        <option value="" selected>فاقد کارت گرافیک</option>
                                        @php
                                            $graphic_cards = \App\Models\Catalogs\GraphicCard::join('companies', 'graphic_cards.company_id', '=', 'companies.id')
                                                ->orderBy('companies.name')
                                                ->get(['graphic_cards.id', 'companies.name', 'graphic_cards.model', 'graphic_cards.ram_size']);
                                        @endphp
                                        @foreach($graphic_cards as $graphic_card)
                                            <option value="{{ $graphic_card->id }}">
                                                {{ $graphic_card->name . ' - ' . $graphic_card->model . ' - ' . $graphic_card->ram_size }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label for="networkcard"
                                           class="block text-gray-700 text-sm font-bold mb-2">کارت شبکه*</label>
                                    <select id="networkcard" class="border rounded-md w-full px-3 py-2"
                                            name="networkcard">
                                        <option value="" selected>فاقد کارت شبکه</option>
                                        @php
                                            $networkcards = \App\Models\Catalogs\NetworkCard::join('companies', 'network_cards.company_id', '=', 'companies.id')
                                                ->orderBy('companies.name')
                                                ->get(['network_cards.id', 'companies.name', 'network_cards.model', 'network_cards.connectivity_type']);
                                        @endphp
                                        @foreach($networkcards as $networkcard)
                                            <option value="{{ $networkcard->id }}">
                                                {{ $networkcard->name . ' - ' . $networkcard->model . ' - ' . $networkcard->connectivity_type }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="odd"
                                           class="block text-gray-700 text-sm font-bold mb-2">درایو نوری*</label>
                                    <select id="odd" class="border rounded-md w-full px-3 py-2" name="odd">
                                        <option value="" selected>فاقد درایو نوری</option>
                                        @php
                                            $odds = \App\Models\Catalogs\Odd::join('companies', 'odds.company_id', '=', 'companies.id')
                                                ->orderBy('companies.name')
                                                ->get(['odds.id', 'companies.name', 'odds.model', 'odds.connectivity_type']);
                                        @endphp
                                        @foreach($odds as $odd)
                                            <option value="{{ $odd->id }}">
                                                {{ $odd->name . ' - ' . $odd->model . ' - ' . $odd->connectivity_type }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
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
    <form id="new-monitor">
        @csrf
        <div class="mt-4 mb-4 flex items-center">
            {{--            <div class="fixed z-10 inset-0 overflow-y-auto " id="addMonitorModal">--}}
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
                                <div class="flex">
                                    <div class="ml-3 w-full">
                                        <label for="property_number"
                                               class="block text-gray-700 text-sm font-bold mb-2">کد اموال*</label>
                                        <input type="text" id="property_number" name="property_number"
                                               class="border rounded-md w-full mb-4 px-3 py-2 text-right "
                                               placeholder="کد اموال را وارد کنید">
                                    </div>
                                    <div class="w-full">
                                        <label for="delivery_date"
                                               class="block text-gray-700 text-sm font-bold mb-2">تاریخ تحویل</label>
                                        <input type="text" id="delivery_date" name="delivery_date"
                                               class="border rounded-md w-full mb-4 px-3 py-2 text-right"
                                               placeholder="با فرمت : 1402/05/04">
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="monitor"
                                           class="block text-gray-700 text-sm font-bold mb-2">مانیتور*</label>
                                    <select id="monitor" class="border rounded-md w-full px-3 py-2" name="monitor">
                                        <option value="" disabled selected>انتخاب کنید</option>
                                        @php
                                            $monitors = \App\Models\Catalogs\Monitor::join('companies', 'monitors.company_id', '=', 'companies.id')
                                                ->orderBy('companies.name')
                                                ->get([ 'companies.name', 'monitors.id', 'monitors.model', 'monitors.size']);
                                        @endphp
                                        @foreach($monitors as $monitor)
                                            <option value="{{ $monitor->id }}">
                                                {{ $monitor->name . ' - ' . $monitor->model. ' - ' . $monitor->size.' inch' }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
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
    <form id="new-printer">
        @csrf
        <div class="mt-4 mb-4 flex items-center">
            {{--            <div class="fixed z-10 inset-0 overflow-y-auto " id="addMonitorModal">--}}
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
                                <div class="flex">
                                    <div class="ml-3 w-full">
                                        <label for="property_number"
                                               class="block text-gray-700 text-sm font-bold mb-2">کد اموال*</label>
                                        <input type="text" id="property_number" name="property_number"
                                               class="border rounded-md w-full mb-4 px-3 py-2 text-right "
                                               placeholder="کد اموال را وارد کنید">
                                    </div>
                                    <div class="w-full">
                                        <label for="delivery_date"
                                               class="block text-gray-700 text-sm font-bold mb-2">تاریخ تحویل</label>
                                        <input type="text" id="delivery_date" name="delivery_date"
                                               class="border rounded-md w-full mb-4 px-3 py-2 text-right"
                                               placeholder="با فرمت : 1402/05/04">
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="printer"
                                           class="block text-gray-700 text-sm font-bold mb-2">پرینتر*</label>
                                    <select id="printer" class="border rounded-md w-full px-3 py-2" name="printer">
                                        <option value="" disabled selected>انتخاب کنید</option>
                                        @php
                                            $printers = \App\Models\Catalogs\Printer::join('companies', 'printers.company_id', '=', 'companies.id')
                                                ->orderBy('companies.name')
                                                ->get([ 'companies.name', 'printers.id', 'printers.model']);
                                        @endphp
                                        @foreach($printers as $printer)
                                            <option value="{{ $printer->id }}">
                                                {{ $printer->name . ' - ' . $printer->model }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
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
    <form id="new-scanner">
        @csrf
        <div class="mt-4 mb-4 flex items-center">
            {{--            <div class="fixed z-10 inset-0 overflow-y-auto " id="addMonitorModal">--}}
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
                                <div class="flex">
                                    <div class="ml-3 w-full">
                                        <label for="property_number"
                                               class="block text-gray-700 text-sm font-bold mb-2">کد اموال*</label>
                                        <input type="text" id="property_number" name="property_number"
                                               class="border rounded-md w-full mb-4 px-3 py-2 text-right "
                                               placeholder="کد اموال را وارد کنید">
                                    </div>
                                    <div class="w-full">
                                        <label for="delivery_date"
                                               class="block text-gray-700 text-sm font-bold mb-2">تاریخ تحویل</label>
                                        <input type="text" id="delivery_date" name="delivery_date"
                                               class="border rounded-md w-full mb-4 px-3 py-2 text-right"
                                               placeholder="با فرمت : 1402/05/04">
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="scanner"
                                           class="block text-gray-700 text-sm font-bold mb-2">اسکنر*</label>
                                    <select id="scanner" class="border rounded-md w-full px-3 py-2" name="scanner">
                                        <option value="" disabled selected>انتخاب کنید</option>
                                        @php
                                            $scanners = \App\Models\Catalogs\Scanner::join('companies', 'scanners.company_id', '=', 'companies.id')
                                                ->orderBy('companies.name')
                                                ->get([ 'companies.name', 'scanners.id', 'scanners.model']);
                                        @endphp
                                        @foreach($scanners as $scanner)
                                            <option value="{{ $scanner->id }}">
                                                {{ $scanner->name . ' - ' . $scanner->model }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
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
    <form id="new-copymachine">
        @csrf
        <div class="mt-4 mb-4 flex items-center">
            {{--            <div class="fixed z-10 inset-0 overflow-y-auto " id="addMonitorModal">--}}
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
                                <div class="flex">
                                    <div class="ml-3 w-full">
                                        <label for="property_number"
                                               class="block text-gray-700 text-sm font-bold mb-2">کد اموال*</label>
                                        <input type="text" id="property_number" name="property_number"
                                               class="border rounded-md w-full mb-4 px-3 py-2 text-right "
                                               placeholder="کد اموال را وارد کنید">
                                    </div>
                                    <div class="w-full">
                                        <label for="delivery_date"
                                               class="block text-gray-700 text-sm font-bold mb-2">تاریخ تحویل</label>
                                        <input type="text" id="delivery_date" name="delivery_date"
                                               class="border rounded-md w-full mb-4 px-3 py-2 text-right"
                                               placeholder="با فرمت : 1402/05/04">
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="copymachine"
                                           class="block text-gray-700 text-sm font-bold mb-2">دستگاه کپی*</label>
                                    <select id="copymachine" class="border rounded-md w-full px-3 py-2"
                                            name="copymachine">
                                        <option value="" disabled selected>انتخاب کنید</option>
                                        @php
                                            $copyMachines = \App\Models\Catalogs\CopyMachine::join('companies', 'copy_machines.company_id', '=', 'companies.id')
                                                ->orderBy('companies.name')
                                                ->get([ 'companies.name', 'copy_machines.id', 'copy_machines.model']);
                                        @endphp
                                        @foreach($copyMachines as $copyMachine)
                                            <option value="{{ $copyMachine->id }}">
                                                {{ $copyMachine->name . ' - ' . $copyMachine->model }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
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
    <form id="new-voip">
        @csrf
        <div class="mt-4 mb-4 flex items-center">
            {{--            <div class="fixed z-10 inset-0 overflow-y-auto " id="addMonitorModal">--}}
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
                                <div class="flex">
                                    <div class="ml-3 w-full">
                                        <label for="property_number"
                                               class="block text-gray-700 text-sm font-bold mb-2">کد اموال*</label>
                                        <input type="text" id="property_number" name="property_number"
                                               class="border rounded-md w-full mb-4 px-3 py-2 text-right "
                                               placeholder="کد اموال را وارد کنید">
                                    </div>
                                    <div class="w-full">
                                        <label for="delivery_date"
                                               class="block text-gray-700 text-sm font-bold mb-2">تاریخ تحویل</label>
                                        <input type="text" id="delivery_date" name="delivery_date"
                                               class="border rounded-md w-full mb-4 px-3 py-2 text-right"
                                               placeholder="با فرمت : 1402/05/04">
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="VOIP"
                                           class="block text-gray-700 text-sm font-bold mb-2">VOIP*</label>
                                    <select id="VOIP" class="border rounded-md w-full px-3 py-2" name="VOIP">
                                        <option value="" disabled selected>انتخاب کنید</option>
                                        @php
                                            $VOIPs = \App\Models\Catalogs\VOIP::join('companies', 'voips.company_id', '=', 'companies.id')
                                                ->orderBy('companies.name')
                                                ->get([ 'companies.name', 'voips.id', 'voips.model']);
                                        @endphp
                                        @foreach($VOIPs as $VOIP)
                                            <option value="{{ $VOIP->id }}">
                                                {{ $VOIP->name . ' - ' . $VOIP->model }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
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

    {{--    Comment--}}
    <form id="new-comment">
        @csrf
        <div class="mt-4 mb-4 flex items-center">
            {{--                        <div class="fixed z-10 inset-0 overflow-y-auto " id="addCommentModal">--}}
            <div class="fixed z-10 inset-0 overflow-y-auto hidden" id="addCommentModal">
                <div
                    class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center  sm:block sm:p-0">
                    <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                        <div class="absolute inset-0 bg-gray-500 opacity-75 addcomment"></div>
                    </div>
                    <div
                        class="inline-block align-bottom bg-white rounded-lg text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full sm:max-w-[550px]">
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                                ثبت کار جدید
                            </h3>
                            <div class="mt-4">
                                <div class="">
                                    <div class="ml-3 w-full">
                                        <label for="title"
                                               class="block text-gray-700 text-sm font-bold mb-2">موضوع*</label>
                                        <input type="text" id="title" name="title"
                                               class="border rounded-md w-full mb-4 px-3 py-2 text-right "
                                               placeholder="موضوع را وارد کنید">
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label for="jobs"
                                           class="block text-gray-700 text-sm font-bold mb-2">کارها</label>
                                    <select id="jobs[]" class="border rounded-md w-full px-3 py-2 h-72" name="jobs[]"
                                            multiple>
                                        @php
                                            $jobs = \App\Models\Catalogs\Job::orderBy('title')->get();
                                        @endphp
                                        @foreach($jobs as $job)
                                            <option value="{{ $job->id }}">
                                                {{ $job->title  }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label for="description"
                                           class="block text-gray-700 text-sm font-bold mb-2">توضیحات*</label>
                                    <textarea id="description" name="description"
                                              class="border rounded-md w-full px-3 py-2"></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit"
                                    class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                                ثبت کار
                            </button>
                            <button id="cancel-add-comment" type="button"
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
            <div class="flex pb-3">
                <h3 class="font-bold pr-5 pt-2 ml-3">اطلاعات کیس</h3>
                <button type="submit"
                        class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300 AddCase">
                    ثبت کیس جدید
                </button>
            </div>
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
                                <th class=" px-3 py-3  font-bold ">عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($eq_cases as $case)
                                <tr class="even:bg-gray-300 odd:bg-white">
                                    <td class=" px-3 py-3 "> {{ $case->property_number }}</td>
                                    <td class=" px-3 py-3 ">{{ $case->stamp_number }}</td>
                                    <td class=" px-3 py-3 ">{{ $case->computer_name  }}</td>
                                    <td class=" px-3 py-3 ">
                                        @php
                                            $caseInfo = \App\Models\Catalogs\Cases::join('companies', 'cases.company_id', '=', 'companies.id')
                                            ->select('cases.*', 'companies.name as company_name') // انتخاب فیلدهای مورد نیاز
                                            ->find($case->case);
                                        @endphp
                                        {{ $caseInfo->company_name . ' ' . $caseInfo->model  }}
                                    </td>
                                    <td class=" px-3 py-3 ">
                                        @php
                                            $powerInfo = \App\Models\Catalogs\Power::join('companies', 'powers.company_id', '=', 'companies.id')
                                            ->select('powers.*', 'companies.name as company_name')
                                            ->find($case->power);
                                        @endphp
                                        {{ $powerInfo->company_name . ' ' . $powerInfo->model. ' ' . $powerInfo->output_voltage.'W'  }}
                                    </td>
                                    <td class=" px-3 py-3 ">
                                        @php
                                            $motherboardInfo = \App\Models\Catalogs\Motherboard::join('companies', 'motherboards.company_id', '=', 'companies.id')
                                            ->select('motherboards.*', 'companies.name as company_name')
                                            ->find($case->motherboard);
                                        @endphp
                                        {{ $motherboardInfo->company_name . ' ' . $motherboardInfo->model. ' ' . $motherboardInfo->ram_slot_generation  }}
                                    </td>
                                    <td class=" px-3 py-3 ">
                                        @php
                                            $cpuInfo = \App\Models\Catalogs\cpu::join('companies', 'cpus.company_id', '=', 'companies.id')
                                            ->select('cpus.*', 'companies.name as company_name')
                                            ->find($case->cpu);
                                        @endphp
                                        {{ $cpuInfo->company_name . ' ' . $cpuInfo->model. ' n' . $cpuInfo->generation  }}
                                    </td>
                                    <td class=" px-3 py-3 ">
                                        @php
                                            $ramInfo = \App\Models\Catalogs\ram::join('companies', 'rams.company_id', '=', 'companies.id')
                                            ->select('rams.*', 'companies.name as company_name')
                                            ->find($case->ram1);
                                        @endphp
                                        {{ $ramInfo->company_name . ' ' . $ramInfo->model. ' ' . $ramInfo->generation  }}

                                        @if($case->ram2)
                                            <br>
                                            @php
                                                $ramInfo = \App\Models\Catalogs\ram::join('companies', 'rams.company_id', '=', 'companies.id')
                                                ->select('rams.*', 'companies.name as company_name')
                                                ->find($case->ram2);
                                            @endphp
                                            {{ $ramInfo->company_name . ' ' . $ramInfo->model. ' ' . $ramInfo->generation  }}
                                        @endif

                                        @if($case->ram3)
                                            <br>
                                            @php
                                                $ramInfo = \App\Models\Catalogs\ram::join('companies', 'rams.company_id', '=', 'companies.id')
                                                ->select('rams.*', 'companies.name as company_name')
                                                ->find($case->ram3);
                                            @endphp
                                            {{ $ramInfo->company_name . ' ' . $ramInfo->model. ' ' . $ramInfo->generation  }}
                                        @endif

                                        @if($case->ram4)
                                            <br>
                                            @php
                                                $ramInfo = \App\Models\Catalogs\ram::join('companies', 'rams.company_id', '=', 'companies.id')
                                                ->select('rams.*', 'companies.name as company_name')
                                                ->find($case->ram4);
                                            @endphp
                                            {{ $ramInfo->company_name . ' ' . $ramInfo->model. ' ' . $ramInfo->generation  }}
                                        @endif

                                    </td>
                                    <td class=" px-3 py-3 ">
                                        @php
                                            $graphicCardInfo = \App\Models\Catalogs\GraphicCard::join('companies', 'graphic_cards.company_id', '=', 'companies.id')
                                            ->select('graphic_cards.*', 'companies.name as company_name')
                                            ->find($case->graphic_card);
                                        @endphp
                                        {{ $graphicCardInfo->company_name . ' ' . $graphicCardInfo->model. ' ' . $graphicCardInfo->ram_size  }}
                                    </td>
                                    <td class=" px-3 py-3 ">
                                        @php
                                            $hddInfo = \App\Models\Catalogs\Harddisk::join('companies', 'harddisks.company_id', '=', 'companies.id')
                                            ->select('harddisks.*', 'companies.name as company_name')
                                            ->find($case->hdd1);
                                        @endphp
                                        {{ $hddInfo->company_name . ' ' . $hddInfo->model. ' ' . $hddInfo->capacity  }}

                                        @if($case->hdd2)
                                            <br>
                                            @php
                                                $hddInfo = \App\Models\Catalogs\Harddisk::join('companies', 'harddisks.company_id', '=', 'companies.id')
                                                ->select('harddisks.*', 'companies.name as company_name')
                                                ->find($case->hdd2);
                                            @endphp
                                            {{ $hddInfo->company_name . ' ' . $hddInfo->model. ' ' . $hddInfo->capacity  }}
                                        @endif

                                        @if($case->hdd3)
                                            <br>
                                            @php
                                                $hddInfo = \App\Models\Catalogs\Harddisk::join('companies', 'harddisks.company_id', '=', 'companies.id')
                                                ->select('harddisks.*', 'companies.name as company_name')
                                                ->find($case->hdd3);
                                            @endphp
                                            {{ $hddInfo->company_name . ' ' . $hddInfo->model. ' ' . $hddInfo->capacity  }}
                                        @endif

                                        @if($case->hdd4)
                                            <br>
                                            @php
                                                $hddInfo = \App\Models\Catalogs\Harddisk::join('companies', 'harddisks.company_id', '=', 'companies.id')
                                                ->select('harddisks.*', 'companies.name as company_name')
                                                ->find($case->hdd4);
                                            @endphp
                                            {{ $hddInfo->company_name . ' ' . $hddInfo->model. ' ' . $hddInfo->capacity  }}
                                        @endif
                                    </td>
                                    <td class=" px-3 py-3 ">
                                        <button type="submit"
                                                class="px-4 py-2 mr-3 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300 EditCase">
                                            ویرایش
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="flex p-3">
                            <h3 class="font-bold text-red-500 ml-4 mt-2">این کاربر کیس ثبت شده ندارد</h3>
                        </div>
                    @endif
                </div>
            </div>

            {{--            Monitors--}}
            <div class="flex pb-3 pt-6">
                <h3 class="font-bold pr-5 pt-2 ml-3">اطلاعات مانیتور</h3>
                <button type="submit"
                        class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300 AddMonitor">
                    ثبت مانیتور جدید
                </button>
            </div>
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
                            <tbody>
                            @foreach($eq_monitors as $monitors)
                                <tr class="even:bg-gray-300 odd:bg-white">
                                    <td class=" px-3 py-3 "> {{ $monitors->property_number }}</td>
                                    <td class=" px-3 py-3 ">
                                        @php
                                            $monitorInfo = \App\Models\Catalogs\Monitor::join('companies', 'monitors.company_id', '=', 'companies.id')
                                            ->select('monitors.*', 'companies.name as company_name')
                                            ->find($monitors->id);
                                        @endphp
                                        {{ $monitorInfo->company_name  }}
                                    </td>
                                    <td class=" px-3 py-3 ">
                                        {{ $monitorInfo->model   }}
                                    </td>
                                    <td class=" px-3 py-3 ">
                                        {{  $monitorInfo->size  }}
                                    </td>
                                    <td class=" px-3 py-3 ">
                                        <button type="submit"
                                                class="px-4 py-2 mr-3 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300 EditMonitor">
                                            ویرایش
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="flex p-3">
                            <h3 class="font-bold text-red-500 ml-4 mt-2">این کاربر مانیتور ثبت شده ندارد</h3>
                        </div>
                    @endif
                </div>
            </div>

            {{--            Printers--}}
            <div class="flex pb-3 pt-6">
                <h3 class="font-bold pr-5 pt-2 ml-3">اطلاعات پرینتر</h3>
                <button type="submit"
                        class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300 AddPrinter">
                    ثبت پرینتر جدید
                </button>
            </div>
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
                            <tbody>
                            @foreach($eq_printers as $printers)
                                <tr class="even:bg-gray-300 odd:bg-white">
                                    <td class=" px-3 py-3 "> {{ $printers->property_number }}</td>
                                    <td class=" px-3 py-3 ">
                                        @php
                                            $printerInfo = \App\Models\Catalogs\Printer::join('companies', 'printers.company_id', '=', 'companies.id')
                                            ->select('printers.*', 'companies.name as company_name')
                                            ->find($printers->id);
                                        @endphp
                                        {{ $printerInfo->company_name  }}
                                    </td>
                                    <td class=" px-3 py-3 ">
                                        {{ $printerInfo->model }}
                                    </td>
                                    <td class=" px-3 py-3 ">
                                        <button type="submit"
                                                class="px-4 py-2 mr-3 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300 EditPrinter">
                                            ویرایش
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="flex p-3">
                            <h3 class="font-bold text-red-500 ml-4 mt-2">این کاربر پرینتر ثبت شده ندارد</h3>
                        </div>
                    @endif
                </div>
            </div>

            {{--            Scanners--}}
            <div class="flex pb-3 pt-6">
                <h3 class="font-bold pr-5 pt-2 ml-3">اطلاعات اسکنر</h3>
                <button type="submit"
                        class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300 AddScanner">
                    ثبت اسکنر جدید
                </button>
            </div>
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
                            <tbody>
                            @foreach($eq_scanners as $scanners)
                                <tr class="even:bg-gray-300 odd:bg-white">
                                    <td class=" px-3 py-3 "> {{ $scanners->property_number }}</td>
                                    <td class=" px-3 py-3 ">
                                        @php
                                            $scannerInfo = \App\Models\Catalogs\Scanner::join('companies', 'scanners.company_id', '=', 'companies.id')
                                            ->select('scanners.*', 'companies.name as company_name')
                                            ->find($scanners->id);
                                        @endphp
                                        {{ $scannerInfo->company_name  }}
                                    </td>
                                    <td class=" px-3 py-3 ">
                                        {{ $scannerInfo->model }}
                                    </td>
                                    <td class=" px-3 py-3 ">
                                        <button type="submit"
                                                class="px-4 py-2 mr-3 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300 EditScanner">
                                            ویرایش
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="flex p-3">
                            <h3 class="font-bold text-red-500 ml-4 mt-2">این کاربر اسکنر ثبت شده ندارد</h3>
                        </div>
                    @endif
                </div>
            </div>

            {{--            Copy Machines--}}
            <div class="flex pb-3 pt-6">
                <h3 class="font-bold pr-5 pt-2 ml-3">اطلاعات دستگاه کپی</h3>
                <button type="submit"
                        class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300 AddCopyMachine">
                    ثبت دستگاه کپی جدید
                </button>
            </div>
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
                            <tbody>
                            @foreach($eq_copy_machines as $copy_machines)
                                <tr class="even:bg-gray-300 odd:bg-white">
                                    <td class=" px-3 py-3 "> {{ $copy_machines->property_number }}</td>
                                    <td class=" px-3 py-3 ">
                                        @php
                                            $copy_machineInfo = \App\Models\Catalogs\CopyMachine::join('companies', 'copy_machines.company_id', '=', 'companies.id')
                                            ->select('copy_machines.*', 'companies.name as company_name')
                                            ->find($copy_machines->id);
                                        @endphp
                                        {{ $copy_machineInfo->company_name  }}
                                    </td>
                                    <td class=" px-3 py-3 ">
                                        {{ $copy_machineInfo->model }}
                                    </td>
                                    <td class=" px-3 py-3 ">
                                        <button type="submit"
                                                class="px-4 py-2 mr-3 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300 EditCopyMachine">
                                            ویرایش
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="flex p-3">
                            <h3 class="font-bold text-red-500 ml-4 mt-2">این کاربر دستگاه کپی ثبت شده ندارد</h3>
                        </div>
                    @endif
                </div>
            </div>

            {{--            VOIPs--}}
            <div class="flex pb-3 pt-6">
                <h3 class="font-bold pr-5 pt-2 ml-3">اطلاعات VOIP</h3>
                <button type="submit"
                        class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300 AddVOIP">
                    ثبت VOIP جدید
                </button>
            </div>
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
                            <tbody>
                            @foreach($eq_VOIPs as $VOIPs)
                                <tr class="even:bg-gray-300 odd:bg-white">
                                    <td class=" px-3 py-3 "> {{ $VOIPs->property_number }}</td>
                                    <td class=" px-3 py-3 ">
                                        @php
                                            $VOIPInfo = \App\Models\Catalogs\Voip::join('companies', 'voips.company_id', '=', 'companies.id')
                                            ->select('voips.*', 'companies.name as company_name')
                                            ->find($VOIPs->id);
                                        @endphp
                                        {{ $VOIPInfo->company_name  }}
                                    </td>
                                    <td class=" px-3 py-3 ">
                                        {{ $VOIPInfo->model }}
                                    </td>
                                    <td class=" px-3 py-3 ">
                                        <button type="submit"
                                                class="px-4 py-2 mr-3 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300 EditVOIP">
                                            ویرایش
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="flex p-3">
                            <h3 class="font-bold text-red-500 ml-4 mt-2">این کاربر VOIP ثبت شده ندارد</h3>
                        </div>
                    @endif
                </div>
            </div>

            {{--            Comment--}}
            <div class="flex pb-3 pt-6">
                <h3 class="font-bold pr-5 pt-2 ml-3">اطلاعات کارهای انجام شده</h3>
                <button type="submit"
                        class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300 AddComment">
                    ثبت کار جدید
                </button>
            </div>
            <div class="bg-white rounded shadow flex flex-col">
                <div class="max-w-full items-center overflow-x-auto">
                    @php
                        $comments=\App\Models\Comment::where('person_id',$personId)->get();
                    @endphp

                        <table  class="w-full border-collapse rounded-lg overflow-hidden text-center">
                            <thead>
                            <tr class="bg-gradient-to-r from-blue-400 to-purple-500 items-center text-center text-white">
                                <th class=" px-6 py-3  font-bold ">موضوع</th>
                                <th class=" px-3 py-3  font-bold ">کارها</th>
                                <th class=" px-3 py-3  font-bold ">توضیحات</th>
                                <th class=" px-3 py-3  font-bold ">عملیات</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($comments as $comment)
                                <tr class="even:bg-gray-300 odd:bg-white">
                                    <td class=" px-3 py-3 "> {{ $comment->title }}</td>
                                    <td class=" px-3 py-3 ">
                                        @if($comment->jobs)
                                            @foreach (json_decode($comment->jobs) as $job)
                                                @php
                                                    $jobInfo=\App\Models\Catalogs\Job::find($job);
                                                @endphp
                                                {{ $jobInfo->title }}
                                                @unless ($loop->last)
                                                    |
                                                @endunless
                                            @endforeach
                                        @endif
                                    </td>
                                    <td class=" px-3 py-3 ">
                                        {{ $comment->description }}
                                    </td>
                                    <td class=" px-3 py-3 ">
                                        <button type="submit"
                                                class="px-4 py-2 mr-3 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300 EditComment">
                                            ویرایش
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="flex p-3">
                            <h3 @if(!$comments->isEmpty()) hidden="hidden" @endif class="font-bold text-red-500 ml-4 mt-2" id="CommentErr">برای این پرسنل، کار ثبت نشده است.</h3>
                        </div>
                </div>
            </div>

        </div>
    </main>
@endsection
