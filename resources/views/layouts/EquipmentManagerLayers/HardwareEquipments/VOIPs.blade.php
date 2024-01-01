<form id="new-voip">
    @csrf
    <div class="flex items-center">
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
                                           class="border rounded-md w-full mb-4 px-3 py-2 text-right deliveryDate"
                                           placeholder="با فرمت : 1402/05/04">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label for="VOIP"
                                       class="block text-gray-700 text-sm font-bold mb-2">VOIP*</label>
                                <select id="VOIP" class="border rounded-md w-96 px-3 py-2 select2" name="VOIP">
                                    <option value="" disabled selected>انتخاب کنید</option>
                                    @php
                                        $VOIPs = \App\Models\Catalogs\Voip::join('companies', 'voips.company_id', '=', 'companies.id')
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

<div class="bg-white rounded shadow flex flex-col">
    <div class="max-w-full items-center overflow-x-auto">
        @php
            $eq_VOIPs=\App\Models\EquipmentedVoip::where('person_id',$personId)->get();
        @endphp
        <table class="w-full border-collapse rounded-lg overflow-hidden text-center">
            <thead>
            <tr class="bg-gradient-to-r from-blue-400 to-purple-500 items-center text-center text-white">
                <th class="font-bold w-8">
                    <button type="submit"
                            class="px-4 py-2 mr-3 bg-green-500 text-white rounded-md hover:bg-green-600 focus:outline-none focus:ring focus:border-blue-300 AddVOIP">
                        جدید
                    </button>
                </th>
                <th class="font-bold ">کد اموال VOIP</th>
                <th class="font-bold ">شرکت سازنده VOIP</th>
                <th class="font-bold ">مدل VOIP</th>
                <th class="font-bold ">عملیات</th>
            </tr>
            </thead>
            @if(!$eq_VOIPs->isEmpty())
                <tbody>
                @foreach($eq_VOIPs as $VOIPs)
                    <tr class="even:bg-gray-300 odd:bg-white">
                        <td class=" px-3 py-1 "></td>
                        <td class=" px-3 py-1 "> {{ $VOIPs->property_number }}</td>
                        <td class=" px-3 py-1 ">
                            @php
                                $VOIPInfo = \App\Models\Catalogs\Voip::join('companies', 'voips.company_id', '=', 'companies.id')
                                ->select('voips.*', 'companies.name as company_name')
                                ->find($VOIPs->voip_id);
                            @endphp
                            {{ $VOIPInfo->company_name  }}
                        </td>
                        <td class=" px-3 py-1 ">
                            {{ $VOIPInfo->model }}
                        </td>
                        <td class=" px-3 py-1 ">
                            <div class="mb-2">
                                <button type="submit"
                                        class="px-1 py-1 mr-3 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300 EditVOIP">
                                    ویرایش
                                </button>
                            </div>
                            <div>
                                <button type="submit" data-type="voip" data-id="{{ $VOIPs->id }}"
                                        class="px-1 py-1 mr-3 bg-blue-500 text-white rounded-md hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-300 MoveEquipment">
                                    انتقال
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            @endif
        </table>
    </div>
</div>
