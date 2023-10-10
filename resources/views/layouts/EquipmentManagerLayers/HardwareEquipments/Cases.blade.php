<form id="new-case">
    @csrf
    <div class="mb-4 flex items-center">
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
                                           class="border rounded-md w-full mb-4 px-3 py-2 text-right deliveryDate"
                                           placeholder="با فرمت : 1402/05/04">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="case"
                                       class="block text-gray-700 text-sm font-bold mb-2">کیس*</label>
                                <select id="case" class="border rounded-md w-96 px-3 py-2 select2" name="case">
                                    <option value="" disabled selected>انتخاب کنید</option>
                                    @php
                                        $cases = \App\Models\Catalogs\Cases::join('companies', 'cases.company_id', '=', 'companies.id')
                                            ->where('cases.active',1)->orderBy('companies.name')
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
                                <select id="motherboard" class="border rounded-md w-96 px-3 py-2 select2"
                                        name="motherboard">
                                    <option value="" disabled selected>انتخاب کنید</option>
                                    @php
                                        $motherboards = \App\Models\Catalogs\Motherboard::join('companies', 'motherboards.company_id', '=', 'companies.id')
                                            ->where('motherboards.active',1)->orderBy('companies.name')
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
                                <select id="power" class="border rounded-md w-96 px-3 py-2 select2" name="power">
                                    <option value="" disabled selected>انتخاب کنید</option>
                                    @php
                                        $powers = \App\Models\Catalogs\Power::join('companies', 'powers.company_id', '=', 'companies.id')
                                            ->where('powers.active',1)->orderBy('companies.name')
                                            ->get(['powers.id', 'companies.name', 'powers.model', 'powers.output_voltage']);
                                    @endphp
                                    @foreach($powers as $power)
                                        <option value="{{ $power->id }}">
                                            {{ $power->name . ' - ' . $power->model. ' - ' . $power->output_voltage }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="cpu"
                                       class="block text-gray-700 text-sm font-bold mb-2">پردازنده*</label>
                                <select id="cpu" class="border rounded-md w-96 px-3 py-2 select2" name="cpu">
                                    <option value="" disabled selected>انتخاب کنید</option>
                                    @php
                                        $cpus = \App\Models\Catalogs\cpu::join('companies', 'cpus.company_id', '=', 'companies.id')
                                            ->where('cpus.active',1)->orderBy('cpus.model')
                                            ->get(['cpus.id', 'companies.name', 'cpus.model']);
                                    @endphp
                                    @foreach($cpus as $cpu)
                                        <option value="{{ $cpu->id }}">
                                            {{ $cpu->name . ' - ' . $cpu->model }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div id="ram1Div" class="flex">
                                <div class="ml-3 w-2/4">
                                    <label for="ram1"
                                           class="block text-gray-700 text-sm font-bold mt-3 whitespace-nowrap">رم
                                        1*</label>
                                    <select id="ram1" class="border rounded-md w-72 px-3 py-2 select2" name="ram1">
                                        <option value="" disabled selected>انتخاب کنید</option>
                                        @php
                                            $rams = \App\Models\Catalogs\Ram::join('companies', 'rams.company_id', '=', 'companies.id')
                                                ->where('rams.active',1)->orderBy('companies.name')
                                                ->get(['rams.id', 'companies.name', 'rams.model', 'rams.type', 'rams.size']);
                                        @endphp
                                        @foreach($rams as $ram)
                                            <option value="{{ $ram->id }}">
                                                {{ $ram->name . ' - ' . $ram->model . ' - ' . $ram->type. ' - ' . $ram->size}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="ml-3 mt-8 w-2/4 text-center">
                                    <button type="button" id="addRAM"
                                            class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                                        + اضافه کردن رم
                                    </button>
                                </div>
                            </div>
                            <div id="ram2Div" class="flex hidden">
                                <div class="w-full ">
                                    <label for="ram2"
                                           class="block text-gray-700 text-sm font-bold mt-3 whitespace-nowrap">رم
                                        2</label>
                                    <select id="ram2" class="border rounded-md w-96 px-3 py-2 select2" name="ram2">
                                        <option value="" selected>فاقد رم</option>
                                        @php
                                            $rams = \App\Models\Catalogs\Ram::join('companies', 'rams.company_id', '=', 'companies.id')
                                                ->where('rams.active',1)->orderBy('companies.name')
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
                            <div id="ram3Div" class="flex hidden">
                                <div class="w-full ">
                                    <label for="ram3"
                                           class="block text-gray-700 text-sm font-bold mt-3 whitespace-nowrap">رم
                                        3</label>
                                    <select id="ram3" class="border rounded-md w-96 px-3 py-2 select2" name="ram3">
                                        <option value="" selected>فاقد رم</option>
                                        @php
                                            $rams = \App\Models\Catalogs\Ram::join('companies', 'rams.company_id', '=', 'companies.id')
                                                ->where('rams.active',1)->orderBy('companies.name')
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
                            <div id="ram4Div" class="flex hidden">
                                <div class="w-full ">
                                    <label for="ram4"
                                           class="block text-gray-700 text-sm font-bold mt-3 whitespace-nowrap">رم
                                        4</label>
                                    <select id="ram4" class="border rounded-md w-96 px-3 py-2 select2" name="ram4">
                                        <option value="" selected>فاقد رم</option>
                                        @php
                                            $rams = \App\Models\Catalogs\Ram::join('companies', 'rams.company_id', '=', 'companies.id')
                                                ->where('rams.active',1)->orderBy('companies.name')
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
                            <div class="flex">
                                <div class="w-full">
                                    <label for="hdd1"
                                           class="block text-gray-700 text-sm font-bold mt-3 whitespace-nowrap">هارد
                                        1*</label>
                                    <select id="hdd1" class="border rounded-md w-72 px-3 py-2 select2" name="hdd1">
                                        <option value="" disabled selected>انتخاب کنید</option>
                                        @php
                                            $hdds = \App\Models\Catalogs\Harddisk::join('companies', 'harddisks.company_id', '=', 'companies.id')
                                                ->where('harddisks.type','!=','External')
                                                ->where('harddisks.active',1)->orderBy('companies.name')
                                                ->get(['harddisks.id', 'companies.name', 'harddisks.model', 'harddisks.capacity','harddisks.connectivity_type',]);
                                        @endphp
                                        @foreach($hdds as $hdd)
                                            <option value="{{ $hdd->id }}">
                                                {{ $hdd->name . ' - ' . $hdd->model . ' - ' . $hdd->capacity. ' - ' . $hdd->connectivity_type}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="ml-3 mt-8 w-full text-center">
                                    <button type="button" id="addHDD"
                                            class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                                        + اضافه کردن هارد
                                    </button>
                                </div>
                            </div>
                            <div id="hdd2Div" class="flex hidden">
                                <div class="w-full">
                                    <label for="hdd2"
                                           class="block text-gray-700 text-sm font-bold mt-3 whitespace-nowrap">هارد
                                        2</label>
                                    <select id="hdd2" class="border rounded-md w-96 px-3 py-2 select2" name="hdd2">
                                        <option value="" selected>فاقد هارد</option>
                                        @php
                                            $hdds = \App\Models\Catalogs\Harddisk::join('companies', 'harddisks.company_id', '=', 'companies.id')
                                                ->where('harddisks.type','!=','External')
                                                ->where('harddisks.active',1)->orderBy('companies.name')
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
                            <div id="hdd3Div" class="flex hidden">
                                <div class="w-full">
                                    <label for="hdd3"
                                           class="block text-gray-700 text-sm font-bold mt-3 whitespace-nowrap">هارد
                                        3</label>
                                    <select id="hdd3" class="border rounded-md w-96 px-3 py-2 select2" name="hdd3">
                                        <option value="" selected>فاقد هارد</option>
                                        @php
                                            $hdds = \App\Models\Catalogs\Harddisk::join('companies', 'harddisks.company_id', '=', 'companies.id')
                                                ->where('harddisks.type','!=','External')
                                                ->where('harddisks.active',1)->orderBy('companies.name')
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
                            <div id="hdd4Div" class="flex hidden">
                                <div class="w-full">
                                    <label for="hdd4"
                                           class="block text-gray-700 text-sm font-bold mt-3 whitespace-nowrap">هارد
                                        4</label>
                                    <select id="hdd4" class="border rounded-md w-96 px-3 py-2 select2" name="hdd4">
                                        <option value="" selected>فاقد هارد</option>
                                        @php
                                            $hdds = \App\Models\Catalogs\Harddisk::join('companies', 'harddisks.company_id', '=', 'companies.id')
                                                ->where('harddisks.type','!=','External')
                                                ->where('harddisks.active',1)->orderBy('companies.name')
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
                            <div class="mb-4 mt-4">
                                <label for="graphiccard"
                                       class="block text-gray-700 text-sm font-bold mb-2">کارت گرافیک مجزا*</label>
                                <select id="graphiccard" class="border rounded-md w-96 px-3 py-2 select2"
                                        name="graphiccard">
                                    <option value="" selected>فاقد کارت گرافیک</option>
                                    @php
                                        $graphic_cards = \App\Models\Catalogs\GraphicCard::join('companies', 'graphic_cards.company_id', '=', 'companies.id')
                                            ->where('graphic_cards.active',1)->orderBy('companies.name')
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
                                <select id="networkcard" class="border rounded-md w-96 px-3 py-2 select2"
                                        name="networkcard">
                                    <option value="" selected>فاقد کارت شبکه</option>
                                    @php
                                        $networkcards = \App\Models\Catalogs\NetworkCard::join('companies', 'network_cards.company_id', '=', 'companies.id')
                                            ->where('network_cards.active',1)->orderBy('companies.name')
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
                                <select id="odd" class="border rounded-md w-96 px-3 py-2 select2" name="odd">
                                    <option value="" selected>فاقد درایو نوری</option>
                                    @php
                                        $odds = \App\Models\Catalogs\Odd::join('companies', 'odds.company_id', '=', 'companies.id')
                                            ->where('odds.active',1)->orderBy('companies.name')
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

<form id="edit-case">
    @csrf
    <div class="mb-4 flex items-center">
        {{--            <div class="fixed z-10 inset-0 overflow-y-auto " id="addCaseModal">--}}
        <div class="fixed z-10 inset-0 overflow-y-auto hidden" id="editCaseModal">
            <div
                class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center  sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75 editcase"></div>
                </div>
                <div
                    class="inline-block align-bottom bg-white rounded-lg text-right overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:w-full sm:max-w-[550px]">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                            ویرایش کیس تخصیص داده شده به کاربر
                        </h3>
                        <div class="mt-4">
                            <div class="flex">
                                <div class="ml-3 w-full">
                                    <label for="edited_property_number"
                                           class="block text-gray-700 text-sm font-bold mb-2">کد اموال*</label>
                                    <input type="text" id="edited_property_number" name="edited_property_number"
                                           class="border rounded-md w-full mb-4 px-3 py-2 text-right "
                                           placeholder="کد اموال را وارد کنید">
                                </div>
                                <div class="w-full">
                                    <label for="edited_stamp_number"
                                           class="block text-gray-700 text-sm font-bold mb-2">کد پلمپ*</label>
                                    <input type="text" id="edited_stamp_number" name="edited_stamp_number"
                                           class="border rounded-md w-full mb-4 px-3 py-2 text-right"
                                           placeholder="کد پلمپ را وارد کنید">
                                </div>
                            </div>
                            <div class="flex">
                                <div class="ml-3 w-full">
                                    <label for="edited_computer_name"
                                           class="block text-gray-700 text-sm font-bold mb-2">نام کامپیوتر</label>
                                    <input type="text" id="edited_computer_name" name="edited_computer_name"
                                           class="border rounded-md w-full mb-4 px-3 py-2 text-right"
                                           placeholder="نام کامپیوتر را وارد کنید">
                                </div>
                                <div class="w-full">
                                    <label for="edited_delivery_date"
                                           class="block text-gray-700 text-sm font-bold mb-2">تاریخ تحویل</label>
                                    <input type="text" id="edited_delivery_date" name="edited_delivery_date"
                                           class="border rounded-md w-full mb-4 px-3 py-2 text-right deliveryDate"
                                           placeholder="با فرمت : 1402/05/04">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="edited_case"
                                       class="block text-gray-700 text-sm font-bold mb-2">کیس*</label>
                                <select id="edited_case" class="border rounded-md w-96 px-3 py-2 select2" name="edited_case">
                                    <option value="" disabled selected>انتخاب کنید</option>
                                    @php
                                        $cases = \App\Models\Catalogs\Cases::join('companies', 'cases.company_id', '=', 'companies.id')
                                            ->where('cases.active',1)->orderBy('companies.name')
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
                                <label for="edited_motherboard"
                                       class="block text-gray-700 text-sm font-bold mb-2">مادربورد*</label>
                                <select id="edited_motherboard" class="border rounded-md w-96 px-3 py-2 select2"
                                        name="edited_motherboard">
                                    <option value="" disabled selected>انتخاب کنید</option>
                                    @php
                                        $motherboards = \App\Models\Catalogs\Motherboard::join('companies', 'motherboards.company_id', '=', 'companies.id')
                                            ->where('motherboards.active',1)->orderBy('companies.name')
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
                                <label for="edited_power"
                                       class="block text-gray-700 text-sm font-bold mb-2">منبع تغذیه*</label>
                                <select id="edited_power" class="border rounded-md w-96 px-3 py-2 select2" name="edited_power">
                                    <option value="" disabled selected>انتخاب کنید</option>
                                    @php
                                        $powers = \App\Models\Catalogs\Power::join('companies', 'powers.company_id', '=', 'companies.id')
                                            ->where('powers.active',1)->orderBy('companies.name')
                                            ->get(['powers.id', 'companies.name', 'powers.model', 'powers.output_voltage']);
                                    @endphp
                                    @foreach($powers as $power)
                                        <option value="{{ $power->id }}">
                                            {{ $power->name . ' - ' . $power->model. ' - ' . $power->output_voltage }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-4">
                                <label for="edited_cpu"
                                       class="block text-gray-700 text-sm font-bold mb-2">پردازنده*</label>
                                <select id="edited_cpu" class="border rounded-md w-96 px-3 py-2 select2" name="edited_cpu">
                                    <option value="" disabled selected>انتخاب کنید</option>
                                    @php
                                        $cpus = \App\Models\Catalogs\cpu::join('companies', 'cpus.company_id', '=', 'companies.id')
                                            ->where('cpus.active',1)->orderBy('cpus.model')
                                            ->get(['cpus.id', 'companies.name', 'cpus.model']);
                                    @endphp
                                    @foreach($cpus as $cpu)
                                        <option value="{{ $cpu->id }}">
                                            {{ $cpu->name . ' - ' . $cpu->model }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div id="edited_ram1Div" class="flex">
                                <div class="ml-3 w-2/4">
                                    <label for="edited_ram1"
                                           class="block text-gray-700 text-sm font-bold mt-3 whitespace-nowrap">رم
                                        1*</label>
                                    <select id="edited_ram1" class="border rounded-md w-72 px-3 py-2 select2" name="edited_ram1">
                                        <option value="" disabled selected>انتخاب کنید</option>
                                        @php
                                            $rams = \App\Models\Catalogs\Ram::join('companies', 'rams.company_id', '=', 'companies.id')
                                                ->where('rams.active',1)->orderBy('companies.name')
                                                ->get(['rams.id', 'companies.name', 'rams.model', 'rams.type', 'rams.size']);
                                        @endphp
                                        @foreach($rams as $ram)
                                            <option value="{{ $ram->id }}">
                                                {{ $ram->name . ' - ' . $ram->model . ' - ' . $ram->type. ' - ' . $ram->size}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="ml-3 mt-8 w-2/4 text-center">
                                    <button type="button" id="edited_addRAM"
                                            class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                                        + اضافه کردن رم
                                    </button>
                                </div>
                            </div>
                            <div id="edited_ram2Div" class="flex hidden">
                                <div class="w-full ">
                                    <label for="edited_ram2"
                                           class="block text-gray-700 text-sm font-bold mt-3 whitespace-nowrap">رم
                                        2</label>
                                    <select id="edited_ram2" class="border rounded-md w-96 px-3 py-2 select2" name="edited_ram2">
                                        <option value="" selected>فاقد رم</option>
                                        @php
                                            $rams = \App\Models\Catalogs\Ram::join('companies', 'rams.company_id', '=', 'companies.id')
                                                ->where('rams.active',1)->orderBy('companies.name')
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
                            <div id="edited_ram3Div" class="flex hidden">
                                <div class="w-full ">
                                    <label for="edited_ram3"
                                           class="block text-gray-700 text-sm font-bold mt-3 whitespace-nowrap">رم
                                        3</label>
                                    <select id="edited_ram3" class="border rounded-md w-96 px-3 py-2 select2" name="edited_ram3">
                                        <option value="" selected>فاقد رم</option>
                                        @php
                                            $rams = \App\Models\Catalogs\Ram::join('companies', 'rams.company_id', '=', 'companies.id')
                                                ->where('rams.active',1)->orderBy('companies.name')
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
                            <div id="edited_ram4Div" class="flex hidden">
                                <div class="w-full ">
                                    <label for="edited_ram4"
                                           class="block text-gray-700 text-sm font-bold mt-3 whitespace-nowrap">رم
                                        4</label>
                                    <select id="edited_ram4" class="border rounded-md w-96 px-3 py-2 select2" name="edited_ram4">
                                        <option value="" selected>فاقد رم</option>
                                        @php
                                            $rams = \App\Models\Catalogs\Ram::join('companies', 'rams.company_id', '=', 'companies.id')
                                                ->where('rams.active',1)->orderBy('companies.name')
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
                            <div class="flex">
                                <div class="w-full">
                                    <label for="edited_hdd1"
                                           class="block text-gray-700 text-sm font-bold mt-3 whitespace-nowrap">هارد
                                        1*</label>
                                    <select id="edited_hdd1" class="border rounded-md w-72 px-3 py-2 select2" name="edited_hdd1">
                                        <option value="" disabled selected>انتخاب کنید</option>
                                        @php
                                            $hdds = \App\Models\Catalogs\Harddisk::join('companies', 'harddisks.company_id', '=', 'companies.id')
                                                ->where('harddisks.type','!=','External')
                                                ->where('harddisks.active',1)->orderBy('companies.name')
                                                ->get(['harddisks.id', 'companies.name', 'harddisks.model', 'harddisks.capacity','harddisks.connectivity_type',]);
                                        @endphp
                                        @foreach($hdds as $hdd)
                                            <option value="{{ $hdd->id }}">
                                                {{ $hdd->name . ' - ' . $hdd->model . ' - ' . $hdd->capacity. ' - ' . $hdd->connectivity_type}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="ml-3 mt-8 w-full text-center">
                                    <button type="button" id="edited_addHDD"
                                            class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                                        + اضافه کردن هارد
                                    </button>
                                </div>
                            </div>
                            <div id="edited_hdd2Div" class="flex hidden">
                                <div class="w-full">
                                    <label for="edited_hdd2"
                                           class="block text-gray-700 text-sm font-bold mt-3 whitespace-nowrap">هارد
                                        2</label>
                                    <select id="edited_hdd2" class="border rounded-md w-96 px-3 py-2 select2" name="edited_hdd2">
                                        <option value="" selected>فاقد هارد</option>
                                        @php
                                            $hdds = \App\Models\Catalogs\Harddisk::join('companies', 'harddisks.company_id', '=', 'companies.id')
                                                ->where('harddisks.type','!=','External')
                                                ->where('harddisks.active',1)->orderBy('companies.name')
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
                            <div id="edited_hdd3Div" class="flex hidden">
                                <div class="w-full">
                                    <label for="edited_hdd3"
                                           class="block text-gray-700 text-sm font-bold mt-3 whitespace-nowrap">هارد
                                        3</label>
                                    <select id="edited_hdd3" class="border rounded-md w-96 px-3 py-2 select2" name="edited_hdd3">
                                        <option value="" selected>فاقد هارد</option>
                                        @php
                                            $hdds = \App\Models\Catalogs\Harddisk::join('companies', 'harddisks.company_id', '=', 'companies.id')
                                                ->where('harddisks.type','!=','External')
                                                ->where('harddisks.active',1)->orderBy('companies.name')
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
                            <div id="edited_hdd4Div" class="flex hidden">
                                <div class="w-full">
                                    <label for="edited_hdd4"
                                           class="block text-gray-700 text-sm font-bold mt-3 whitespace-nowrap">هارد
                                        4</label>
                                    <select id="edited_hdd4" class="border rounded-md w-96 px-3 py-2 select2" name="edited_hdd4">
                                        <option value="" selected>فاقد هارد</option>
                                        @php
                                            $hdds = \App\Models\Catalogs\Harddisk::join('companies', 'harddisks.company_id', '=', 'companies.id')
                                                ->where('harddisks.type','!=','External')
                                                ->where('harddisks.active',1)->orderBy('companies.name')
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
                            <div class="mb-4 mt-4">
                                <label for="edited_graphiccard"
                                       class="block text-gray-700 text-sm font-bold mb-2">کارت گرافیک مجزا*</label>
                                <select id="edited_graphiccard" class="border rounded-md w-96 px-3 py-2 select2"
                                        name="edited_graphiccard">
                                    <option value="" selected>فاقد کارت گرافیک</option>
                                    @php
                                        $graphic_cards = \App\Models\Catalogs\GraphicCard::join('companies', 'graphic_cards.company_id', '=', 'companies.id')
                                            ->where('graphic_cards.active',1)->orderBy('companies.name')
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
                                <label for="edited_networkcard"
                                       class="block text-gray-700 text-sm font-bold mb-2">کارت شبکه*</label>
                                <select id="edited_networkcard" class="border rounded-md w-96 px-3 py-2 select2"
                                        name="edited_networkcard">
                                    <option value="" selected>فاقد کارت شبکه</option>
                                    @php
                                        $networkcards = \App\Models\Catalogs\NetworkCard::join('companies', 'network_cards.company_id', '=', 'companies.id')
                                            ->where('network_cards.active',1)->orderBy('companies.name')
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
                                <label for="edited_odd"
                                       class="block text-gray-700 text-sm font-bold mb-2">درایو نوری*</label>
                                <select id="edited_odd" class="border rounded-md w-96 px-3 py-2 select2" name="edited_odd">
                                    <option value="" selected>فاقد درایو نوری</option>
                                    @php
                                        $odds = \App\Models\Catalogs\Odd::join('companies', 'odds.company_id', '=', 'companies.id')
                                            ->where('odds.active',1)->orderBy('companies.name')
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
                        <input type="hidden" name="eq_id" value="" id="eq_id">
                        <input type="hidden" name="eq_type" value="" id="eq_type">
                        <button type="submit"
                                class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300">
                            ویرایش
                        </button>
                        <button id="cancel-edit-case" type="button"
                                class="mt-3 w-full inline-flex justify-center px-4 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 focus:outline-none focus:ring focus:border-blue-300 sm:mt-0 sm:w-auto">
                            انصراف
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    function toggleModal(modalID) {
        var modal = document.getElementById(modalID);
        if (modal.classList.contains('modal-active')) {
            modal.classList.remove('animate-fade-in');
            modal.classList.add('animate-fade-out');
            setTimeout(() => {
                modal.classList.remove('modal-active');
                modal.classList.remove('animate-fade-out');
            }, 150);
        } else {
            modal.classList.add('modal-active');
            modal.classList.remove('animate-fade-out');
            modal.classList.add('animate-fade-in');
        }
    }

    $(document).on('click', '.EditEqCase', function () {
        toggleModal(editCaseModal.id);
        $.ajax({
            type: 'GET', url: '/getEquipmentInfo', data: {
                id: $(this).data('id'),
                type: $(this).data('type')
            }, success: function (response) {
                if (response) {
                    eq_id.value = response.id;
                    eq_type.value='case';
                    edited_property_number.value=response.property_number;
                    edited_stamp_number.value=response.stamp_number;
                    edited_computer_name.value=response.computer_name;
                    edited_delivery_date.value=response.delivery_date;
                    $("#edited_case").val(response.case).trigger("change");
                    $("#edited_motherboard").val(response.motherboard).trigger("change");
                    $("#edited_power").val(response.power).trigger("change");
                    $("#edited_cpu").val(response.cpu).trigger("change");
                    if (response.ram1){
                        $("#edited_ram1").val(response.ram1).trigger("change");
                        edited_ram1Div.classList.remove('hidden');
                    }
                    if (response.ram2){
                        $("#edited_ram2").val(response.ram2).trigger("change");
                        edited_ram2Div.classList.remove('hidden');
                    }
                    if (response.ram3){
                        $("#edited_ram3").val(response.ram3).trigger("change");
                        edited_ram3Div.classList.remove('hidden');
                    }
                    if (response.ram4){
                        $("#edited_ram4").val(response.ram4).trigger("change");
                        edited_ram4Div.classList.remove('hidden');
                    }
                    if (response.hdd1){
                        $("#edited_hdd1").val(response.hdd1).trigger("change");
                    }
                    if (response.hdd2){
                        $("#edited_hdd2").val(response.hdd2).trigger("change");
                        edited_hdd2Div.classList.remove('hidden');
                    }
                    if (response.hdd3){
                        $("#edited_hdd3").val(response.hdd3).trigger("change");
                        edited_hdd3Div.classList.remove('hidden');
                    }
                    if (response.hdd4){
                        $("#edited_hdd4").val(response.hdd4).trigger("change");
                        edited_hdd4Div.classList.remove('hidden');
                    }
                    $("#edited_graphiccard").val(response.graphic_card).trigger("change");
                    $("#edited_networkcard").val(response.network_card).trigger("change");
                    $("#edited_odd").val(response.odd).trigger("change");
                }
            }
        });
    });
</script>
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
                            {{ $powerInfo->company_name . ' ' . $powerInfo->model. ' ' . $powerInfo->output_voltage  }}
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
                            {{ $cpuInfo->company_name . ' ' . $cpuInfo->model. ' ' . $cpuInfo->generation  }}
                        </td>
                        <td class=" px-3 py-3 ">
                            @php
                                $ramInfo = \App\Models\Catalogs\ram::join('companies', 'rams.company_id', '=', 'companies.id')
                                ->select('rams.*', 'companies.name as company_name')
                                ->find($case->ram1);
                            @endphp
                            {{ $ramInfo->company_name . ' ' . $ramInfo->model. ' ' . $ramInfo->size. ' ' . $ramInfo->type. ' ' . $ramInfo->frequency  }}

                            @if($case->ram2)
                                <hr>
                                @php
                                    $ramInfo = \App\Models\Catalogs\ram::join('companies', 'rams.company_id', '=', 'companies.id')
                                    ->select('rams.*', 'companies.name as company_name')
                                    ->find($case->ram2);
                                @endphp
                                {{ $ramInfo->company_name . ' ' . $ramInfo->model. ' ' . $ramInfo->size. ' ' . $ramInfo->type. ' ' . $ramInfo->frequency }}
                            @endif

                            @if($case->ram3)
                                <hr>
                                @php
                                    $ramInfo = \App\Models\Catalogs\ram::join('companies', 'rams.company_id', '=', 'companies.id')
                                    ->select('rams.*', 'companies.name as company_name')
                                    ->find($case->ram3);
                                @endphp
                                {{ $ramInfo->company_name . ' ' . $ramInfo->model. ' ' . $ramInfo->size. ' ' . $ramInfo->type. ' ' . $ramInfo->frequency }}
                            @endif

                            @if($case->ram4)
                                <hr>
                                @php
                                    $ramInfo = \App\Models\Catalogs\ram::join('companies', 'rams.company_id', '=', 'companies.id')
                                    ->select('rams.*', 'companies.name as company_name')
                                    ->find($case->ram4);
                                @endphp
                                {{ $ramInfo->company_name . ' ' . $ramInfo->model. ' ' . $ramInfo->size. ' ' . $ramInfo->type. ' ' . $ramInfo->frequency }}
                            @endif

                        </td>
                        <td class=" px-3 py-3 ">
                            @if($case->graphic_card)
                            @php
                                $graphicCardInfo = \App\Models\Catalogs\GraphicCard::join('companies', 'graphic_cards.company_id', '=', 'companies.id')
                                ->select('graphic_cards.*', 'companies.name as company_name')
                                ->find($case->graphic_card);
                            @endphp
                            {{ $graphicCardInfo->company_name . ' ' . $graphicCardInfo->model. ' ' . $graphicCardInfo->ram_size }}
                            @else
                                Onboard
                            @endif
                        </td>
                        <td class=" px-3 py-3 ">
                            @php
                                $hddInfo = \App\Models\Catalogs\Harddisk::join('companies', 'harddisks.company_id', '=', 'companies.id')
                                ->select('harddisks.*', 'companies.name as company_name')
                                ->find($case->hdd1);
                            @endphp
                            {{ $hddInfo->company_name . ' ' . $hddInfo->model. ' ' . $hddInfo->capacity }}

                            @if($case->hdd2)
                                <hr>
                                @php
                                    $hddInfo = \App\Models\Catalogs\Harddisk::join('companies', 'harddisks.company_id', '=', 'companies.id')
                                    ->select('harddisks.*', 'companies.name as company_name')
                                    ->find($case->hdd2);
                                @endphp
                                {{ $hddInfo->company_name . ' ' . $hddInfo->model. ' ' . $hddInfo->capacity  }}
                            @endif

                            @if($case->hdd3)
                                <hr>
                                @php
                                    $hddInfo = \App\Models\Catalogs\Harddisk::join('companies', 'harddisks.company_id', '=', 'companies.id')
                                    ->select('harddisks.*', 'companies.name as company_name')
                                    ->find($case->hdd3);
                                @endphp
                                {{ $hddInfo->company_name . ' ' . $hddInfo->model. ' ' . $hddInfo->capacity }}
                            @endif

                            @if($case->hdd4)
                                <hr>
                                @php
                                    $hddInfo = \App\Models\Catalogs\Harddisk::join('companies', 'harddisks.company_id', '=', 'companies.id')
                                    ->select('harddisks.*', 'companies.name as company_name')
                                    ->find($case->hdd4);
                                @endphp
                                {{ $hddInfo->company_name . ' ' . $hddInfo->model. ' ' . $hddInfo->capacity }}
                            @endif
                        </td>
                        <td class=" px-3 py-3 ">
                            <button type="submit" data-type="case" data-id="{{ $case->id }}"
                                    class="px-4 py-2 mr-3 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300 EditEqCase">
                                ویرایش
                            </button>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @else
            <div class="flex p-3">
                <h3 class="font-bold text-red-500 ml-4">این کاربر کیس ثبت شده ندارد</h3>
            </div>
        @endif
    </div>
</div>
